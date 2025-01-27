FROM php:8.4-fpm

RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN pecl install redis && docker-php-ext-enable redis

RUN apt-get install -y nano mc

WORKDIR /app

RUN curl -sSfL https://raw.githubusercontent.com/auth0/auth0-cli/main/install.sh | sh -s -- -b .

COPY . .
COPY .env.example .env

RUN chown -R www-data:www-data .

USER www-data

RUN composer install
RUN php artisan key:generate

USER root

EXPOSE 9000

CMD ["php-fpm"]
