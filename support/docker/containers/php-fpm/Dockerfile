FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    wget \
    zlib1g-dev \
    libmcrypt-dev \
    libicu-dev \
    libzip-dev


RUN docker-php-ext-configure intl && \
    docker-php-ext-install pdo pdo_mysql intl

WORKDIR /var/www/app
