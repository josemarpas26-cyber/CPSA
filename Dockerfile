FROM php:8.3-apache

# Ajustes MPM
RUN a2dismod mpm_event mpm_worker || true \
    && a2enmod mpm_prefork

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer
# Instalar dependências do PHP
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

# Mod rewrite
RUN a2enmod rewrite

# Ajuste DocumentRoot do Apache
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Copiar projeto e ajustar permissões
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

WORKDIR /var/www/html
