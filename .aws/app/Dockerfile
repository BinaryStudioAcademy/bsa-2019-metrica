FROM lenchv/metrica-php-fpm:latest

WORKDIR /app

ARG UID=1000
ARG GID=1000
ENV USERNAME=www-data

# Fix permissions
RUN usermod -u $UID $USERNAME \
    && groupmod -g $GID $USERNAME \
    && mkdir -p /home/$USERNAME \
    && chown -R $USERNAME:$USERNAME /home/$USERNAME \
	&& mkdir -p /app \
    && chown -R $USERNAME:$USERNAME /app \
    && chown -R $USERNAME:$USERNAME /var/www

COPY ./.aws/app/php-ini-overrides.ini /etc/php/7.3/fpm/conf.d/99-overrides.ini
COPY --chown=www-data ./.aws/app/migration.sh /home/$USERNAME/migration.sh
COPY --chown=www-data ./backend /app

USER $USERNAME

RUN composer install --no-interaction
