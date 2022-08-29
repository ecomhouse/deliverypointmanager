FROM php:8.1-fpm

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev libxml2-dev libssh2-1-dev \
    && docker-php-ext-install intl opcache soap \
    && pecl install apcu ssh2-1.3.1 \
    && docker-php-ext-enable apcu ssh2 \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN echo "memory_limit=-1" > $PHP_INI_DIR/conf.d/memory-limit.ini

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer