FROM php:8.1-apache
COPY . /var/www/html/
RUN docker-php-ext-install mysqli pdo pdo_mysql && a2enmod rewrite
EXPOSE 10000
CMD ["apache2-foreground"]
