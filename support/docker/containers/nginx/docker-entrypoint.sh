#!/bin/bash

set -e

mkdir -p /var/www/app/public
find /etc/nginx/conf.d/ -name 'default.conf' -exec rm -f {} \;
mkdir -p /etc/nginx/sites-enabled

ln -s /etc/nginx/sites-available/api.conf /etc/nginx/sites-enabled/
cp /etc/nginx/sites-available/default_81.conf /etc/nginx/sites-enabled/default_81.conf

find /etc/nginx/sites-enabled -type f -exec sed -i "s/<<<DOMAIN>>>/${DOMAIN}/g" {} +

exec "nginx"