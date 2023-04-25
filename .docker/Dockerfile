FROM nginx:latest

RUN apt-get -y update && apt -y upgrade
RUN apt-get install -y ca-certificates apt-transport-https software-properties-common curl lsb-release tzdata vim composer
RUN curl -sSL https://packages.sury.org/php/README.txt | bash -x
RUN apt update
RUN apt-get install -y php8.1-fpm  php8.1-common php8.1-mbstring php8.1-xml php8.1-curl php8.1-gd php8.1-ldap php8.1-soap php8.1-zip php8.1-mysql php8.1-pgsql

RUN npm i puppeteer

COPY ./.docker/nginx/conf.d/app.conf /etc/nginx/conf.d/app.conf
RUN sed -i "s/user  nginx/user  www-data www-data/gi" /etc/nginx/nginx.conf
RUN mkdir -p /run/php/

#копируем проект
WORKDIR /var/www

COPY . .

RUN echo '#!/usr/bin/env sh\n\
set -e\n\
php-fpm8.1 -D\n\
nginx -g "daemon off;"' > /docker-entrypoint.sh

EXPOSE 80
ENTRYPOINT ["sh","/docker-entrypoint.sh"]
