#/bin/bash

php /app/artisan config:cache
php /app/artisan config:clear

php /app/artisan queue:work --tries=1
