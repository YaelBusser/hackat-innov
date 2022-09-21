FROM php:8.1.10-cli
RUN docker-php-ext-install pdo_mysql
WORKDIR /var/www/html
