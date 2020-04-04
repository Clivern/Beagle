cd /www

setfacl -dR -m u:www-data:rwX -m u:root:rwX /www/var
setfacl -d -m u:www-data:rwX -m u:root:rwX /www/var
setfacl -R -m u:www-data:rwX -m u:root:rwX /www/var

php-fpm
