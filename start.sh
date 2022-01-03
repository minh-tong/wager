#!/usr/bin/env bash
echo "Building app"
composer install
php artisan config:clear
php artisan cache:clear
echo "Creating the database"
php artisan initdb
php artisan migrate
php -S 0.0.0.0:8080 -t public

exec "$@"