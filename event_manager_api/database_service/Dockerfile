FROM php:8.0-apache
RUN docker-php-ext-install mysqli
RUN docker-php-ext-enable mysqli
COPY . /var/www/html/
EXPOSE 80
