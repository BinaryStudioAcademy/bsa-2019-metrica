#!/bin/bash

cp backend/.env.travis backend/.env
docker-compose -f docker-compose.test.yml run --rm app composer install --no-interaction
docker-compose -f docker-compose.test.yml run --rm frontend npm install
docker-compose -f docker-compose.test.yml run --rm frontend npm run build
docker-compose -f docker-compose.test.yml run --rm app php artisan key:generate
docker-compose -f docker-compose.test.yml up -d
docker-compose -f docker-compose.test.yml run --rm app php artisan migrate --seed --force
docker-compose -f docker-compose.test.yml run --rm app ./vendor/bin/phpunit
