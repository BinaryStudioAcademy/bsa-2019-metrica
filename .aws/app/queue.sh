#/bin/bash

php /app/artisan queue:work --tries=1
