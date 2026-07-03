FROM php:8.2-apache
RUN apt-get update && apt-get install -y unzip git && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install mysqli pdo pdo_mysql
COPY . /var/www/html/
WORKDIR /var/www/html
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN php composer.phar install --no-dev --optimize-autoloader
RUN a2dismod mpm_event mpm_worker 2>/dev/null; a2enmod mpm_prefork rewrite
EXPOSE 80
CMD ["apache2-foreground"]