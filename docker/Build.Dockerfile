FROM php:8.1-fpm

COPY php.ini $PHP_INI_DIR

RUN apt-get update && apt-get install -y \
    cron \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip


RUN docker-php-ext-configure intl \
    && docker-php-ext-install \
    intl \
    gettext

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN usermod --non-unique --uid 1000 www-data \
 && groupmod --non-unique --gid 1000 www-data

EXPOSE 9000

CMD ['php-fpm']
