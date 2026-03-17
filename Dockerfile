FROM php:8.3-cli

WORKDIR /var/www/html

COPY . .

RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libxml2-dev libonig-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install \
    pdo pdo_mysql mbstring zip xml gd

RUN curl -sS https://getcomposer.org/installer | php \
 && mv composer.phar /usr/local/bin/composer \
 && composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

EXPOSE 80

# ⚠️ Remova o cp .env.example e key:generate da build!
# Use um script de entrada que rode em runtime
CMD bash -c "\
  cp .env.example .env && \
  php artisan key:generate --ansi && \
  php artisan config:clear && \
  php artisan migrate --force && \
  php artisan serve --host=0.0.0.0 --port=80"
