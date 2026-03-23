#!/bin/bash
set -e

PORT=${PORT:-8000}


# --force ignora a confirmação de produção
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

#php artisan migrate --force
#php artisan db:seed --force
php artisan migrate:fresh --seed --force

php artisan storage:link --force 2>/dev/null || true

php artisan serve --host=0.0.0.0 --port=$PORT