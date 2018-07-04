#!/usr/bin/env bash

#== Import script args ==

mysql_dbname=$(echo "$1")
mysql_dbuser=$(echo "$2")
mysql_dbpassword=$(echo "$3")

#== Bash helpers ==

function info {
	echo " "
	echo "--> $1"
	echo " "
}

#== Provision script ==

echo "mysql-server mysql-server/root_password password ${mysql_dbpassword}" | debconf-set-selections
echo "mysql-server mysql-server/root_password_again password ${mysql_dbpassword}" | debconf-set-selections

info "Update OS software"
apt-get update
apt-get upgrade -y

info "Install LAMP"
apt-get install -y apache2
apt-get install -y mysql-server
apt-get install -y php
apt-get install -y libapache2-mod-php php-mcrypt php-mysql

info "Confgiure Apache mod-rewrite"
sed -i "s/AllowOverride None/AllowOverride All/" /etc/apache2/apache2.conf
a2enmod rewrite
systemctl restart apache2
echo "Done!"

info "Confgiure MySQL remote access (Host CLI Tools)"
sed -i "s/.*bind-address.*/bind-address = 0.0.0.0/" /etc/mysql/mysql.conf.d/mysqld.cnf
systemctl restart mysql
echo "Done!"

info "Create MySQL Database"
mysql -uroot -p${mysql_dbpassword} -e "CREATE DATABASE ${mysql_dbname}"
mysql -uroot -p${mysql_dbpassword} -e "CREATE USER '${mysql_dbuser}'@'%' IDENTIFIED BY '${mysql_dbpassword}'"
mysql -uroot -p${mysql_dbpassword} -e "GRANT ALL PRIVILEGES ON ${mysql_dbname}.* TO '${mysql_dbuser}'@'%'"
mysql -uroot -p${mysql_dbpassword} -e "FLUSH PRIVILEGES"
echo "Done!"

info "Install composer"
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
echo "Done!"

info "Set up symlink to synced files for Apache"
rm -rf /var/www
ln -fs /app /var/www
echo "Done!"

info "Set up symlink for Apache Virtual Hosts and enable them"
rm -rf /etc/apache2/sites-available
rm -f /etc/apache2/sites-enabled/000-default.conf
ln -fs /app/vagrant/sites-available /etc/apache2/sites-available
a2ensite vagrant.conf
systemctl restart apache2
echo "Done!"