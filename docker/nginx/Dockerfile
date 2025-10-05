# BASE STAGE
FROM nginx:1.21.6 as base

RUN apt update \
    && apt install -y apache2-utils

WORKDIR /var/www/app

EXPOSE 80 443

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

COPY ./conf/sites-templates /etc/nginx/sites-templates

RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
