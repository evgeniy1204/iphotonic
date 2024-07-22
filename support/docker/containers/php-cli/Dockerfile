FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    libpq-dev \
    wget \
    zlib1g-dev \
    libmcrypt-dev \
    libzip-dev \
    sendmail

WORKDIR /var/www/app

RUN docker-php-ext-install pdo pdo_mysql zip

RUN set -eux; \
    chown -R www-data:www-data /var/www/app

RUN wget https://getcomposer.org/installer -O - -q | php -- --install-dir=/bin --filename=composer --quiet

CMD composer install --no-scripts