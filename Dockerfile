FROM php:7.4

RUN apt-get update -y && apt-get install -y openssl zip unzip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo mysqli pdo_mysql && docker-php-ext-enable pdo_mysql
WORKDIR /app
COPY . /app

EXPOSE 8080
ENTRYPOINT ["/app/init.sh"]