# Dockerfile Laravel para Railway - sem Apache, funciona direto
FROM php:8.3-cli

# Definir diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos do projeto
COPY . .

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libxml2-dev libonig-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install \
    pdo pdo_mysql mbstring zip xml gd

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php \
 && mv composer.phar /usr/local/bin/composer \
 && composer install --no-dev --optimize-autoloader

# Garantir permissões corretas (Laravel precisa disso)
RUN chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

# Garantir que o .env exista e gerar APP_KEY se necessário
RUN cp .env.example .env || true \
 && php artisan key:generate --ansi

# Expor porta padrão do Laravel
EXPOSE 80

# Rodar Laravel com servidor interno
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
