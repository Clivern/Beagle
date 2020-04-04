FROM nginx:stable-alpine

RUN rm /etc/nginx/conf.d/default.conf

ADD turtle.conf /etc/nginx/conf.d/turtle.conf

WORKDIR /etc/nginx/conf.d/
