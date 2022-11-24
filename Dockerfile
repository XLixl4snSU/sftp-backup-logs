FROM alpine:3.17.0
RUN apk add --no-cache nginx php-fpm tzdata openrc curl bash inotify-tools
RUN cp /usr/share/zoneinfo/Europe/Berlin /etc/localtime
COPY ./webserver_files/ /var/www/html/
COPY ./config/webserver.conf /etc/nginx/http.d/default.conf
COPY ./config/php-fpm.conf /etc/php8/php-fpm.d/www.conf
COPY ./scripts/ /home/scripts/
RUN mkdir /run/php/; chmod +x /home/scripts/*
ENTRYPOINT ["/home/scripts/entrypoint.sh"]
