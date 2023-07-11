FROM node:18

WORKDIR /var/www/ui

USER node

COPY docker/dev/node/entry.sh /var/tmp

ENTRYPOINT /var/tmp/entry.sh
