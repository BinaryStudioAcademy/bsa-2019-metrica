FROM php:7.3-fpm-stretch

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install \
    apt-utils \
    libpq-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_pgsql bcmath sockets zip \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN pecl channel-update pecl.php.net \
    && pecl install redis-4.3.0 \
    && pecl install xdebug-2.7.2 \
    && docker-php-ext-enable redis xdebug

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY ./.aws/app/php-ini-overrides.ini /etc/php/7.3/fpm/conf.d/99-overrides.ini
