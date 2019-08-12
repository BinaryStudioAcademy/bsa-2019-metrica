#!/usr/bin/env bash

set -e
set -u
set -o pipefail

# more bash-friendly output for jq
JQ="jq --raw-output --exit-status"

deploy_image() {
    DOCKER_IMAGE=$1
    IMAGE_TAG=$2
    
    docker build -t metrica/$DOCKER_IMAGE:latest -f .aws/$DOCKER_IMAGE/Dockerfile .
    docker tag metrica/$DOCKER_IMAGE:latest $AWS_REPOSITORY_URI/$DOCKER_IMAGE:$IMAGE_TAG
    docker push $AWS_REPOSITORY_URI/$DOCKER_IMAGE
    cleanup_images $DOCKER_IMAGE
}

# sets $task_definition
make_task_def() {
	aws_log='
		{
			"logDriver": "syslog"
		}
	'

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
		"links": [
			"app"
		],
		"logConfiguration": %s
    }' "webserver" "$AWS_REPOSITORY_URI/webserver:$DEPLOY_TYPE" "$aws_log")

	app=$(printf '{
        "name": "%s",
        "image": "%s",
        "essential": true,
		"logConfiguration": %s,
        "memory": 512
    }' "app" "$AWS_REPOSITORY_URI/app:$DEPLOY_TYPE" "$aws_log")

	migration=$(printf '{
        "name": "%s",
        "image": "%s",
        "essential": false,
		"logConfiguration": %s,
		"command": [
			"/bin/bash", "/home/www-data/migration.sh"
		],
        "memory": 64
    }' "migration" "$AWS_REPOSITORY_URI/app:$DEPLOY_TYPE" "$aws_log")

	task_definition="[
		$nginx,
		$app,
		$migration
	]"
}

# reads $family
# sets $revision
register_definition() {
    if revision=$(aws ecs register-task-definition \
        --container-definitions "$task_definition" \
        --network-mode bridge \
        --requires-compatibilities EC2 \
        --task-role-arn ${AWS_ROLE} \
        --execution-role-arn ${AWS_ROLE} \
        --memory 980 \
        --family $AWS_FAMILY | $JQ '.taskDefinition.taskDefinitionArn'); then
        echo "Revision: $revision"
    else
        echo "Failed to register task definition"
        return 1
    fi

}

stop_active_task() {
    ACTIVE_TASK_ID=$(aws ecs list-tasks --cluster $AWS_CLUSTER --service-name $AWS_SERVICE | grep -E "task/.*" | sed -e 's/.*task\/\(.*\)"/\1/')

    aws ecs stop-task --cluster metrica-cluster --task $ACTIVE_TASK_ID >> /dev/null
}

cleanup_images() {
    IMAGE_NAME=$1
    IMAGES_TO_DELETE=$( aws ecr list-images --region $AWS_REGION --repository-name $IMAGE_NAME --filter "tagStatus=UNTAGGED" --query 'imageIds[*]' --output json )

    aws ecr batch-delete-image --region $AWS_REGION --repository-name $IMAGE_NAME --image-ids "$IMAGES_TO_DELETE" || true
}

deploy_cluster() {

    make_task_def
    register_definition $task_definition
    stop_active_task

    if [[ $(aws ecs update-service --cluster $AWS_CLUSTER --service $AWS_SERVICE --task-definition $revision --force-new-deployment | \
                   $JQ '.service.taskDefinition') != $revision ]]; then
        echo "Error updating service."
        return 1
    fi

    echo "Deployed!"

    return 0

}

$(aws ecr get-login --region ${AWS_REGION} --no-include-email)
aws s3 cp s3://${AWS_BUCKET}/envs/.env.app.$DEPLOY_TYPE ./backend/.env
aws s3 cp s3://${AWS_BUCKET}/envs/.env.frontend.$DEPLOY_TYPE ./frontend/.env

docker-compose -f docker-compose.test.yml run --rm node npm run build

deploy_image app $DEPLOY_TYPE
deploy_image webserver $DEPLOY_TYPE

deploy_cluster
