FROM php:7.3-apache

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y locales locales-all && apt-get clean
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Setup debugger
RUN pecl install xdebug-3.1.6 && docker-php-ext-enable xdebug
COPY docker_app/php/php.ini $PHP_INI_DIR/conf.d/
