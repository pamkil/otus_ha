FROM php:8.0-fpm-alpine3.15

ARG UID=1000
ARG GID=1000
ENV UID=${UID}
ENV GID=${GID}

RUN apk add --no-cache autoconf make unzip zlib zip icu-dev zlib-dev curl-dev \
 		imap-dev libxslt-dev libxml2-dev postgresql-dev fcgi \
 		libjpeg-turbo-dev libjpeg-turbo libpng-dev libzip-dev \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install xdebug-3.1.5 \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo tokenizer xml pcntl pdo_pgsql zip intl \
    && apk del -f .build-deps \
    && rm -rf /tmp/pear \
    && mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY ./conf.d /usr/local/etc/php/conf.d
COPY ./php-fpm.d /usr/local/etc/php-fpm.d

WORKDIR /app

COPY ./entrypoint.sh /usr/local/bin/docker-php-entrypoint
RUN chmod +x /usr/local/bin/docker-php-entrypoint

HEALTHCHECK --interval=5s --timeout=3s --start-period=1s \
    CMD REDIRECT_STATUS=true SCRIPT_NAME=/ping SCRIPT_FILENAME=/ping REQUEST_METHOD=GET \
    cgi-fcgi -bind -connect 127.0.0.1:9123 || exit 1
