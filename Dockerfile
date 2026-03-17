FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    git unzip curl \
    libzip-dev zip \
    libpng-dev libxml2-dev libicu-dev \
    && docker-php-ext-install \
        pdo pdo_mysql \
        zip xml dom \
        gd intl mbstring

RUN a2enmod rewrite

COPY . /var/www/html
WORKDIR /var/www/html

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php \
 && mv composer.phar /usr/local/bin/composer

# Instalar dependências
RUN composer install --no-dev --optimize-autoloader

# Permissões Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80
