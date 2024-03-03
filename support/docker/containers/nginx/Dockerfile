FROM nginx:1.20.2-alpine

RUN apk add --no-cache bash nano

COPY config/nginx.conf /etc/nginx/nginx.conf
COPY config/conf.d /etc/nginx/conf.d
COPY config/includes /etc/nginx/includes
COPY config/sites-available /etc/nginx/sites-available

COPY docker-entrypoint.sh /


EXPOSE 80

ENTRYPOINT ["./docker-entrypoint.sh"]