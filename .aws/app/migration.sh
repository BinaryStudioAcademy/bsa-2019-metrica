#/bin/bash

php /app/artisan migrate --force

php /app/artisan queue:work --tries=1 > /proc/1/fd/1 &

while [ true ]
do
    php /app/artisan schedule:run --verbose --no-interaction &
    sleep 60
done
