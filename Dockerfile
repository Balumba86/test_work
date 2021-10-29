FROM php:8.0-fpm-alpine

RUN apk add --no-cache autoconf g++ libmcrypt supervisor make libmcrypt-dev mosquitto-dev nginx tzdata

ADD ./conf/php/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN addgroup -g 1000 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel

RUN chown laravel:laravel /var/www/html

WORKDIR /var/www/html

RUN apk add libpq postgresql-dev ldb-dev libldap openldap-dev && \
    docker-php-ext-install pdo pdo_pgsql pgsql ldap

RUN apk add composer

COPY ./conf/php/nginx.conf /etc/nginx/
COPY ./conf/php/default.conf /etc/nginx/conf.d/

RUN cp /usr/share/zoneinfo/Europe/Moscow /etc/localtime && \
    echo "Europe/Moscow" >  /etc/timezone

COPY ./conf/php/cronjobs /etc/crontabs/root
RUN crontab /etc/crontabs/root

COPY ./conf/php/supervisord.conf /etc/supervisord.conf

ADD src /var/www/html/

RUN mkdir -p /var/log/cron/

ADD ./conf/php/uploads.ini /usr/local/etc/php/conf.d/

### Фронт
#RUN apk add --no-cache nodejs npm yarn

EXPOSE 80
EXPOSE 443

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
