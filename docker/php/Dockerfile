# Official build of PHP - https://hub.docker.com/_/php/
#
# Version follows the latest stable PHP release.
#
# TODO: Determine exact version/tag for base image once in production.
FROM php:7.1.6-fpm-alpine

# Install `intl` PHP module
RUN apk --no-cache add icu-dev
RUN docker-php-ext-install intl

# Install `pdo_mysql` PHP module
RUN docker-php-ext-install pdo_mysql

# Install Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('SHA384', 'composer-setup.php') === '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"
RUN apk --no-cache add git

# Install Dockerize (to wait for MySQL)
ENV DOCKERIZE_VERSION v0.5.0
RUN apk add --no-cache openssl \
    && wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz

# Add custom PHP-FPM settings
COPY php-fpm.conf /usr/local/etc/php-fpm.d/custom.conf

# Add custom entrypoint that runs Composer at startup and redeclare default command
COPY docker-entrypoint /usr/local/bin/
ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]

# Change working directory to standard location to match Nginx container
WORKDIR /app
