#!/bin/bash
set -e

chown node:node -R "/var/www/ui"

if [ ! -f "/var/www/ui/dist/index.html" ]; then
  npm install --prefix="/var/www/ui"
  npm run build-only --prefix="/var/www/ui"
fi

echo "Sleeping..."
# Spin until we receive a SIGTERM (e.g. from `docker stop`)
trap 'exit 143' SIGTERM # exit = 128 + 15 (SIGTERM)
tail -f /dev/null & wait ${!}
