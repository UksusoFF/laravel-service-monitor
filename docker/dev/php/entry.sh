#!/bin/bash
set -e

source "/var/www/api/.env"

#chown www:www -R "/var/www/api"

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

# Временно данные обнуляются каждый раз, до тех пор пока нет стабильной версии
#php artisan migrate:fresh --force
#php artisan orchid:admin admin admin@admin.com password
#php artisan erp:cache
#php artisan import:prop-facilities
#php artisan data:generate

nohup php artisan schedule:run &

php-fpm
