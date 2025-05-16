FROM alpine:3.14

RUN apk update && apk add --no-cache \
    nginx \
    php7 \
    php7-fpm \
    php7-opcache \
    php7-json \
    php7-mbstring \
    php7-pdo \
    php7-pdo_mysql \
    php7-session \
    php7-mysqli \
    supervisor

RUN mkdir -p /var/www/html

COPY containerized/nginx.conf /etc/nginx/nginx.conf
COPY containerized/supervisord.conf /etc/supervisord.conf
COPY . /var/www/html/

RUN chown -R nginx:nginx /var/www/html
EXPOSE 80
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]