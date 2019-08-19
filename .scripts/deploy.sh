#!/usr/bin/env bash

set -e
set -u
set -o pipefail

# more bash-friendly output for jq
JQ="jq --raw-output --exit-status"

deploy_to_docker_hub() {
    DOCKER_IMAGE=$1
    DOCKER_SHARED_IMAGE=$2
    IMAGE_TAG=$3
    
    docker build -t metrica/$DOCKER_IMAGE:latest -f .aws/$DOCKER_IMAGE/Dockerfile .
    docker tag metrica/$DOCKER_IMAGE:latest $DOCKER_HUB_LOGIN/$DOCKER_SHARED_IMAGE:$IMAGE_TAG
    docker push $DOCKER_HUB_LOGIN/$DOCKER_SHARED_IMAGE
    docker image rm -f metrica/$DOCKER_IMAGE:latest
}

deploy_image() {
    DOCKER_IMAGE=$1
    IMAGE_TAG=$2
    
    docker build -t metrica/$DOCKER_IMAGE:latest -f .aws/$DOCKER_IMAGE/Dockerfile .
    docker tag metrica/$DOCKER_IMAGE:latest $AWS_REPOSITORY_URI/$DOCKER_IMAGE:$IMAGE_TAG
    docker push $AWS_REPOSITORY_URI/$DOCKER_IMAGE
}

# sets $task_definition
make_task_def() {
    aws_cloudwatch='{
        "logDriver": "awslogs",
        "options": {
            "awslogs-group": "/ecs/metrica-stage",
            "awslogs-region": "eu-central-1",
            "awslogs-stream-prefix": "ecs"
        }
    }'

    nginx=$(printf '{
        "name": "%s",
        "image": "%s",
        "essential": true,
        "memory": 256,
        "portMappings": [
            {
                "hostPort": 80,
                "protocol": "tcp",
                "containerPort": 80
            },
            {
                "hostPort": 443,
                "protocol": "tcp",
                "containerPort": 443
            }
        ],
		"volumesFrom": [
			{
				"sourceContainer": "app",
				"readOnly": true
			}
		],
		"dependsOn": [
			{
				"containerName": "app",
				"condition": "START"
			}
		],
        "mountPoints": [
            {
                "sourceVolume": "certs",
                "containerPath": "/nginx/certs"
            },
            {
                "sourceVolume": "passwd",
                "containerPath": "/etc/users"
            }
        ],
		"links": [
			"app"
		],
		"logConfiguration": %s
    }' "webserver" "$DOCKER_HUB_LOGIN/metrica-frontend:$DEPLOY_TYPE" "$aws_cloudwatch")

	app=$(printf '{
        "name": "%s",
        "image": "%s",
        "essential": true,
		"logConfiguration": %s,
        "mountPoints": [
            {
                "sourceVolume": "storage",
                "containerPath": "/app/storage/app/public"
            }
        ],
        "repositoryCredentials": {
            "credentialsParameter": "%s"
        },
        "memory": 512
    }' "app" "$DOCKER_HUB_LOGIN/metrica-app:$DEPLOY_TYPE" "$aws_cloudwatch" "$AWS_DOCKER_HUB_ARN")

	migration=$(printf '{
        "name": "%s",
        "image": "%s",
        "essential": false,
		"logConfiguration": %s,
        "repositoryCredentials": {
            "credentialsParameter": "%s"
        },
		"command": [
			"/bin/bash", "/home/www-data/migration.sh", "%s"
		],
        "memory": 192
    }' "migration" "$DOCKER_HUB_LOGIN/metrica-app:$DEPLOY_TYPE" "$aws_cloudwatch" "$AWS_DOCKER_HUB_ARN" "$DEPLOY_TYPE")

	task_definition="[
		$nginx,
		$app,
		$migration
	]"
}

# reads $family
# sets $revision
register_definition() {
    aws_volumes='[
        {
            "name": "storage",
            "host": {
                "sourcePath": "/home/ec2-user/storage"
            }
        },
        {
            "name": "certs",
            "host": {
                "sourcePath": "/home/ec2-user/certs"
            }
        },
        {
            "name": "passwd",
            "host": {
                "sourcePath": "/home/ec2-user/users/"
            }
        }
    ]'

    if revision=$(aws ecs register-task-definition \
        --container-definitions "$task_definition" \
        --network-mode bridge \
        --requires-compatibilities EC2 \
        --task-role-arn ${AWS_ROLE} \
        --execution-role-arn ${AWS_ROLE} \
        --memory 980 \
        --volumes "${aws_volumes}" \
        --family $AWS_FAMILY | $JQ '.taskDefinition.taskDefinitionArn'); then
        echo "Revision: $revision"
    else
        echo "Failed to register task definition"
        return 1
    fi

}

stop_active_task() {
    ACTIVE_TASK_ID=$(aws ecs list-tasks --cluster $AWS_CLUSTER --service-name $AWS_SERVICE | grep -E "task/.*" | sed -e 's/.*task\/\(.*\)"/\1/')

    echo $ACTIVE_TASK_ID
    if [[ -n $ACTIVE_TASK_ID ]]; then
        echo "Stopping task with id: $ACTIVE_TASK_ID"

        aws ecs stop-task --cluster metrica-cluster --task $ACTIVE_TASK_ID > /dev/null
    
        echo "Task stopped: $ACTIVE_TASK_ID"
    fi
}

cleanup_images() {
    IMAGE_NAME=$1
    IMAGES_TO_DELETE=$( aws ecr list-images --region $AWS_REGION --repository-name $IMAGE_NAME --filter "tagStatus=UNTAGGED" --query 'imageIds[*]' --output json )

    aws ecr batch-delete-image --region $AWS_REGION --repository-name $IMAGE_NAME --image-ids "$IMAGES_TO_DELETE" || true
}

deploy_cluster() {

    make_task_def
    register_definition $task_definition
    
    echo "Definition has successfully registered"

    stop_active_task

    echo "Active task stopped"

    if [[ $(aws ecs update-service --cluster $AWS_CLUSTER --service $AWS_SERVICE --task-definition $revision --force-new-deployment | \
                   $JQ '.service.taskDefinition') != $revision ]]; then
        echo "Error updating service."
        return 1
    fi

    echo "Successfully deployed!"

    return 0

}

aws s3 cp s3://${AWS_BUCKET}/envs/.env.app.$DEPLOY_TYPE ./backend/.env
aws s3 cp s3://${AWS_BUCKET}/envs/.env.frontend.$DEPLOY_TYPE ./frontend/.env

docker-compose -f docker-compose.test.yml run --rm node npm run build

docker login --username $DOCKER_HUB_LOGIN --password $DOCKER_HUB_PASSWORD

deploy_to_docker_hub app metrica-app $DEPLOY_TYPE
deploy_to_docker_hub webserver metrica-frontend $DEPLOY_TYPE

$(aws ecr get-login --region ${AWS_REGION} --no-include-email)

deploy_cluster
