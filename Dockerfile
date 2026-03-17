FROM php:8.3-apache

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

# 🔥 FIX DO ERRO
RUN a2dismod mpm_event mpm_worker || true
RUN a2enmod mpm_prefork

RUN a2enmod rewrite
