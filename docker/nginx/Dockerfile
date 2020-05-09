FROM nginx:stable-alpine

RUN rm /etc/nginx/conf.d/default.conf

ADD beagle.conf /etc/nginx/conf.d/beagle.conf

WORKDIR /etc/nginx/conf.d/
