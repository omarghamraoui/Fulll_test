FROM php:8.2-fpm-alpine

# persistent / runtime deps
RUN apk add --no-cache \
    acl \
    fcgi \
    file \
    gettext \
    git \
    icu-dev \
    libzip-dev \
    zlib-dev \
    bash \
    jq \
    wget \
    libxml2-dev \
    ;

RUN docker-php-ext-configure zip
RUN docker-php-ext-install -j$(nproc) \
		intl \
		zip \
		soap \
	;

ENV COMPOSER_HOME /var/www/.composer

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
RUN composer self-update
RUN chown 1000:1000 /usr/local/bin/composer

RUN mkdir -p /var/www/.composer && chown 1000:1000 /var/www/.composer

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions
RUN install-php-extensions mysqli pdo pdo_mysql zip gd intl

RUN echo 'memory_limit = 512M' >> /usr/local/etc/php/php.ini
RUN echo 'upload_max_filesize = 512M' >> /usr/local/etc/php/php.ini

RUN cp /usr/local/etc/php/php.ini /usr/local/etc/php/php-cli.ini \
    && echo 'memory_limit = -1' >> /usr/local/etc/php/php-cli.ini \
    && echo 'max_execution_time = -1' >> /usr/local/etc/php/php-cli.ini \
USER 1000
