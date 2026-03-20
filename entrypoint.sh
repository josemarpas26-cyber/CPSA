#!/bin/bash
set -e

PORT=${PORT:-8000}

cat > .env <<EOF
APP_NAME="CPSA 2025"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=${APP_URL}

LOG_CHANNEL=stderr
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT:-3306}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}

CACHE_STORE=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
EOF

# Composer
composer install --no-dev --optimize-autoloader

# Key
php artisan key:generate --force

# Espera DB (CRÍTICO)
until php artisan migrate --force; do
  echo "DB não pronto, retry..."
  sleep 5
done

# Limpa cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

php artisan migrate:fresh --seed --force
# Migrações (SAFE)
php artisan migrate --force

# Seed opcional
php artisan db:seed --force || true

# Start
php artisan serve --host=0.0.0.0 --port=$PORT
