#/bin/bash

php /app/artisan config:cache
php /app/artisan config:clear

php /app/artisan migrate --force

while [ true ]
do
    php /app/artisan schedule:run --verbose --no-interaction &
    sleep 60
done
