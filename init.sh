#!/usr/bin/env bash
echo "Building app"
#composer install
#php artisan config:clear
php artisan cache:clear
php artisan initdb 
echo "Creating the migration for testing"
php artisan migrate
echo "Testing"
./vendor/bin/phpunit
echo "Creating the migration for production db"
php artisan migrate

php -S 0.0.0.0:8080 -t public

exec "$@"


