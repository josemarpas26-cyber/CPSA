FROM php:8.3-apache

# 💥 RESET MPM (ESSENCIAL)
RUN rm -f /etc/apache2/mods-enabled/mpm_* \
 && a2enmod mpm_prefork

RUN apt-get update && apt-get install -y \
    git unzip curl \
    libzip-dev zip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libxml2-dev libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo pdo_mysql \
        mbstring \
        zip \
        xml \
        gd

RUN a2enmod rewrite
