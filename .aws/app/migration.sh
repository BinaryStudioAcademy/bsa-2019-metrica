#/bin/bash

php /app/artisan migrate --force

php /app/artisan queue:work --tries=1
