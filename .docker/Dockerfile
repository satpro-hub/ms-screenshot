FROM nginx:latest

RUN apt-get -y update && apt -y upgrade
RUN apt-get install -y ca-certificates apt-transport-https software-properties-common curl lsb-release tzdata vim npm
RUN curl -sSL https://packages.sury.org/php/README.txt | bash -x
RUN apt update
RUN apt-get install -y php8.1-fpm  php8.1-common php8.1-mbstring php8.1-xml php8.1-curl php8.1-gd php8.1-ldap php8.1-soap php8.1-zip php8.1-mysql php8.1-pgsql

# установка композера
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '8a6138e2a05a8c28539c9f0fb361159823655d7ad2deecb371b04a83966c61223adc522b0189079e3e9e277cd72b8897') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"

COPY ./.docker/nginx/conf.d/app.conf /etc/nginx/conf.d/app.conf
RUN sed -i "s/user  nginx/user  www-data www-data/gi" /etc/nginx/nginx.conf
RUN mkdir -p /run/php/

#копируем проект
WORKDIR /var/www

COPY . .

RUN mkdir -p bootstrap/cache
RUN chmod -R 777 storage bootstrap/cache

RUN composer install
RUN npm install -g


RUN echo '#!/usr/bin/env sh\n\
set -e\n\
php-fpm8.1 -D\n\
nginx -g "daemon off;"' > /docker-entrypoint.sh

EXPOSE 80
ENTRYPOINT ["sh","/docker-entrypoint.sh"]
