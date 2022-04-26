FROM php:8.1-fpm

RUN apt update && apt install -y git zip
RUN pecl install xdebug
RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable xdebug pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/spec-pattern/