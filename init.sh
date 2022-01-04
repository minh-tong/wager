#!/usr/bin/env bash

echo "Building app"
cp -R .env.example .env
composer install
php artisan config:clear
php artisan cache:clear
php artisan initdb 
echo "Creating the migration for testing"
php artisan migrate
echo "Testing"
./vendor/bin/phpunit
echo "Creating the migration for production db"
php artisan migrate
echo "Generate swagger ui"
php artisan swagger-lume:publish-views
php artisan swagger-lume:generate
cp -a vendor/swagger-api/swagger-ui/dist public/swagger-ui-assets

php -S 0.0.0.0:8080 -t public

exec "$@"
