#!/bin/bash
set -e

source "/var/www/api/.env"

cd "/var/www/api"

if [ ! -f "/var/www/api/vendor/autoload.php" ]; then
  composer install
fi

db_ready() {
  curl "http://${APP_NAME}-db:5432/" 2>&1 | grep '52'
}

until db_ready; do
  >&2 echo "Waiting for database to become available..."
  sleep 1
done
>&2 echo "Database is available"

nohup php artisan schedule:work &>> /var/www/api/storage/logs/artisan.log &

php-fpm
