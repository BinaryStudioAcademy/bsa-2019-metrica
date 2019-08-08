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
				"containerName": "frontend",
				"condition": "START"
			},
			{
				"containerName": "app",
				"condition": "START"
			}
		],
		"links": [
			"frontend",
			"app"
		],
		"logConfiguration": %s
    }' "nginx" "$AWS_REPOSITORY_URI/nginx:$DEPLOY_TYPE" "$aws_log")

	app=$(printf '{
        "name": "%s",
        "image": "%s",
        "essential": true,
		"logConfiguration": %s,
        "memory": 512
    }' "app" "$AWS_REPOSITORY_URI/app:$DEPLOY_TYPE" "$aws_log")

	frontend=$(printf '{
        "name": "%s",
        "image": "%s",
        "essential": true,
		"logConfiguration": %s,
        "memory": 256
    }' "frontend" "$AWS_REPOSITORY_URI/frontend:$DEPLOY_TYPE" "$aws_log")

	migration=$(printf '{
        "name": "%s",
        "image": "%s",
        "essential": false,
		"logConfiguration": %s,
		"command": [
			"php", "/app/artisan", "migrate", "--seed", "--force"
		],
        "memory": 128
    }' "migration" "$AWS_REPOSITORY_URI/app:$DEPLOY_TYPE" "$aws_log")

	task_definition="[
		$nginx,
		$app,
		$frontend,
		$migration
	]"
}

# reads $family
# sets $revision
register_definition() {
    echo $task_definition > test.json
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

deploy_cluster() {

    make_task_def
    register_definition $task_definition

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

deploy_image app $DEPLOY_TYPE
deploy_image frontend $DEPLOY_TYPE

deploy_cluster
