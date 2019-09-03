#!/bin/bash

rm -rf e2e/output

docker-compose -f docker-compose.test.yml restart seleniumapp
docker-compose -f docker-compose.test.yml exec app php artisan migrate:refresh
docker-compose -f docker-compose.test.yml exec app php artisan db:seed --class=DefaultUserAndWebsiteSeeder
docker-compose -f docker-compose.test.yml exec e2e npm run test:travis
