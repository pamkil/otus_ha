FROM php:8.0-cli-alpine3.15

ARG UID=1000
ARG GID=1000
ENV UID=${UID}
ENV GID=${GID}
ENV COMPOSER_ALLOW_SUPERUSER 1

RUN apk add --no-cache autoconf g++ make shadow unzip zlib zip icu-dev zlib-dev curl-dev \
 		imap-dev libxslt-dev libxml2-dev postgresql-dev bash coreutils nano git \
 		libjpeg-turbo-dev libjpeg-turbo libpng-dev libzip-dev \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install xdebug-3.1.5 \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo tokenizer xml pcntl pdo_pgsql zip intl \
    && apk del -f .build-deps \
    && rm -rf /tmp/pear \
    && mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet \
    && rm -rf /root/.composer/cache

COPY ./conf.d /usr/local/etc/php/conf.d

COPY ./wait-for-it.sh /usr/local/bin/wait-for-it
RUN chmod 555 /usr/local/bin/wait-for-it


RUN addgroup -g ${GID} node && adduser -u ${UID} -G node -s /bin/sh -D node
USER node

WORKDIR /app
