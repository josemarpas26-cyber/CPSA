#!/bin/bash
set -e

# Gera .env a partir das variáveis de ambiente do Railway
cat > .env <<EOF
APP_NAME=Laravel
APP_ENV=${APP_ENV:-production}
APP_KEY=
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL:-http://localhost}

DB_CONNECTION=mysql
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT:-3306}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
EOF

php artisan key:generate --ansi
php artisan config:clear
php artisan migrate --force
php artisan serve --host=0.0.0.0 --port=80
