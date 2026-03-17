FROM php:8.3-apache

# 💥 RESET MPM (ESSENCIAL)
# 💥 RESET TOTAL E CONFIG MANUAL
RUN rm -f /etc/apache2/mods-enabled/mpm_* \
 && ln -s /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load \
 && ln -s /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf
 
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
