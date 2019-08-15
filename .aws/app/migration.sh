#/bin/bash

DEPLOY_TYPE=$1

if [[ $DEPLOY_TYPE="production" ]]; then
	php /app/artisan migrate
else
	php /app/artisan migrate --seed --force
fi