#!/bin/sh
set -e
APP_PATH=/var/www/ai-app
cd $APP_PATH
composer install
chmod 777 -R storage
php artisan storage:link
composer dump-autoload
php artisan optimize:clear
php artisan optimize
php artisan migrate
# composer install
php artisan serve --host=0.0.0.0