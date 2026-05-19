#!/bin/sh

# Setup permissions
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache

# Run optimizations
php artisan optimize:clear
php artisan optimize
php artisan view:cache
php artisan event:cache

exec "$@"
