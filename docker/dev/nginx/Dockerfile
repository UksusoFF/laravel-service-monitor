FROM nginx:alpine

COPY docker/dev/nginx/conf.d/* /etc/nginx/conf.d/
RUN rm /etc/nginx/conf.d/default.conf
