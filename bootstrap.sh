#!/usr/bin/env bash

#PhpMyAdmin preparation
debconf-set-selections <<< "mysql-server mysql-server/root_password password root"
debconf-set-selections <<< "mysql-server mysql-server/root_password_again password root"
debconf-set-selections <<< "phpmyadmin phpmyadmin/dbconfig-install boolean true"
debconf-set-selections <<< "phpmyadmin phpmyadmin/app-password-confirm password root"
debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/admin-pass password root"
debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/app-pass password root"
debconf-set-selections <<< "phpmyadmin phpmyadmin/reconfigure-webserver multiselect none"

apt-get update
apt-get -y install apache2 php7.2 libapache2-mod-php7.2 php-curl php-gd php-mysql php-mbstring php-intl php-soap php-xml php-xdebug php-zip php-opcache php-imagick mysql-server mysql-client curl php-cli git acl unzip phpmyadmin php-sqlite3 sqlite3
cd ~
curl -sL https://deb.nodesource.com/setup_10.x -o nodesource_setup.sh
sudo bash nodesource_setup.sh
sudo apt install -y nodejs

# Apache
a2enmod rewrite
sed -i "s/AllowOverride None/AllowOverride All/g" /etc/apache2/apache2.conf
sed -i s/\${APACHE_RUN_USER}/vagrant/g /etc/apache2/apache2.conf
sed -i s/\${APACHE_RUN_GROUP}/vagrant/g /etc/apache2/apache2.conf
sed -i "s#DocumentRoot /var/www/html#DocumentRoot /var/www/html/public#g" /etc/apache2/sites-available/000-default.conf

# PHP
sed -i "s/max_execution_time = 30/max_execution_time = 0/g" /etc/php/7.2/cli/php.ini
cat <<EOT > /etc/php/7.2/apache2/conf.d/31-xdebug.ini
xdebug.remote_enable = 1
xdebug.remote_connect_back = 1
xdebug.remote_port = 9000
xdebug.scream=0
xdebug.cli_color=1
xdebug.show_local_vars=1
EOT
cat <<EOT > /etc/php/7.2/cli/conf.d/31-xdebug.ini
xdebug.remote_enable = 1
xdebug.remote_connect_back = 1
xdebug.remote_port = 9000
xdebug.scream=0
xdebug.cli_color=1
xdebug.show_local_vars=1
EOT

# MySQL
mysql -uroot -proot -e "CREATE DATABASE IF NOT EXISTS budgetbe CHARACTER SET utf8 COLLATE utf8_general_ci;"

# Composer
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Dart Sass
cd /home/vagrant
wget https://github.com/sass/dart-sass/releases/download/1.15.2/dart-sass-1.15.2-linux-x64.tar.gz
tar zxvf dart-sass-1.15.2-linux-x64.tar.gz
ln -s /home/vagrant/dart-sass/sass /usr/bin/sass
chown -R vagrant:vagrant dart-sass

# App related
cd /var/www/html
phpdismod xdebug
composer install --no-scripts
php bin/console assets:install --symlink
echo '' >> /home/vagrant/.bashrc
echo 'cd /var/www/html' >> /home/vagrant/.bashrc
chown vagrant:vagrant -R .

# Clean
service apache2 restart
apt-get -y autoremove

exit 0
