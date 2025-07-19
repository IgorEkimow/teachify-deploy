sudo cp deploy/nginx.conf /etc/nginx/conf.d/default.conf -f
sudo cp deploy/supervisor.conf /etc/supervisor/conf.d/default.conf -f
sudo sed -i -- "s|%SERVER_NAME%|$1|g" /etc/nginx/conf.d/default.conf
sudo service nginx restart
sudo service php8.3-fpm restart
sudo -u www-data php bin/console cache:clear
sudo service supervisor restart