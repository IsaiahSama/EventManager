FROM php:8.0-apache
RUN docker-php-ext-install mysqli
RUN docker-php-ext-enable mysqli
RUN pecl install -o -f redis; rm -rf /tmp/pear; docker-php-ext-enable redis;
RUN a2enmod rewrite
COPY . /var/www/html/
EXPOSE 80
