FROM php:8.2-fpm


RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libicu-dev


RUN docker-php-ext-install \
    pdo_mysql \
    zip \
    intl


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html


RUN chown -R www-data:www-data /var/www/html 

COPY . .


RUN chown -R www-data:www-data /var/www/html