#/bin/bash

DEPLOY_TYPE=$1

php /app/artisan migrate
