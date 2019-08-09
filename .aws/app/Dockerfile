FROM 918681676479.dkr.ecr.eu-central-1.amazonaws.com/php-fpm:latest

COPY ./.aws/app/php-ini-overrides.ini /etc/php/7.3/fpm/conf.d/99-overrides.ini
COPY --chown=www-data ./.aws/app/migration.sh /home/$USERNAME/migration.sh
COPY --chown=www-data ./backend /app

USER $USERNAME

RUN composer install --no-interaction
