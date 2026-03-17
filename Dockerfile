FROM php:8.3-cli

WORKDIR /var/www/html

# Instalar Node.js
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libxml2-dev libonig-dev nodejs npm \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install \
    pdo pdo_mysql mbstring zip xml gd

COPY . .

# Instalar dependências JS e buildar assets
RUN npm install && npm run build

# Instalar Composer e dependências PHP
RUN curl -sS https://getcomposer.org/installer | php \
 && mv composer.phar /usr/local/bin/composer \
 && composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80

CMD ["/entrypoint.sh"]
