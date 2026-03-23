#!/bin/bash
set -e

PORT=${PORT:-8000}

cat > .env <<EOF
APP_NAME="CPSA 2025"
APP_ENV=${APP_ENV:-production}
APP_KEY=base64:placeholder
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL:-https://localhost}

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

composer dump-autoload --optimize

php artisan key:generate --force --ansi

php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# --force ignora a confirmação de produção
php artisan migrate --force

# Seed apenas se a tabela de roles estiver vazia
php artisan db:seed --class=RoleSeeder --force

php artisan storage:link --force 2>/dev/null || true

php artisan serve --host=0.0.0.0 --port=$PORT
