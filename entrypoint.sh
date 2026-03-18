#!/bin/bash
set -e

# Cria o .env com variáveis de ambiente
cat > .env <<EOF
APP_NAME=Laravel
APP_ENV=${APP_ENV:-production}
APP_KEY=base64:placeholder
APP_DEBUG=${APP_DEBUG:-true}
APP_URL=${APP_URL:-http://localhost}

LOG_CHANNEL=stderr
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT:-3306}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}

CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=local
EOF

# Gera a key real por cima do placeholder
php artisan key:generate --force --ansi

# Limpa cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Roda migrations
php artisan migrate:fresh --force

# ⚡️ Roda os seeders
php artisan db:seed --force || true

# Inicia o servidor PHP
php -S 0.0.0.0:$PORT -t public
