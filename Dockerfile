FROM  php:7.4-apache

WORKDIR /var/www/html

COPY . .

RUN chmod -R 777 storage

RUN  docker-php-ext-install mysqli pdo pdo_mysql

WORKDIR /etc/apache2/sites-available

RUN sed -i "s|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public |g" 000-default.conf

RUN a2enmod rewrite

RUN apt-get update
RUN apt-get install nano

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 8000
EXPOSE 80