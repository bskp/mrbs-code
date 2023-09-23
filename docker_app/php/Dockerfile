FROM php:7.3-apache

RUN a2enmod rewrite
RUN docker-php-ext-install mysqli

#COPY docker_app/php.ini/ $PHP_INI_DIR/conf.d/
RUN apt-get update && apt-get install -y locales locales-all && apt-get clean
RUN docker-php-ext-install mysqli pdo pdo_mysql
