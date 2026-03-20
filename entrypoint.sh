#!/bin/bash
set -e

# Define a porta padrão se não estiver definida
PORT=${PORT:-8000}

# Cria o .env com variáveis de ambiente
cat > .env <<EOF
APP_NAME="CPSA 2025"
APP_ENV=${APP_ENV:-production}
APP_KEY=base64:placeholder
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL:-http://localhost}

LOG_CHANNEL=stderr
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT:-3306}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}

CACHE_STORE=database
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=false
SESSION_SAME_SITE=lax
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=local
EOF

# Autoload (garante que os Seeders são encontrados)
composer dump-autoload --optimize

# Gera a key real
php artisan key:generate --force --ansi

# Limpa caches antigas
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear


php artisan migrate:fresh --seed
# Corre apenas uma vez as migrações + seeders
php artisan migrate --force
php artisan db:seed --force

# Inicia o servidor PHP utilizando o Laravel Artisan
php artisan serve --host=0.0.0.0 --port=$PORT