
yum install httpd
yum install mariadb-server
yum install php php-mysqlnd
yum install php-xml php-mbstring php-json

systemctl start httpd
systemctl start mariadb

cd /var/www/html
git clone https://github.com/alvaroies/daltonBar.git


mysql -u root
CREATE DATABASE daltonbar;

mysql -u root daltonbar < schema.sql



---------------------------------------------------------
Si se instala sobre AWS hay que añadir un security group para que la máquina pueda acceder a mysql:

3306	TCP		127.0.0.1/32

---------------------------------------------------------
El fichero .htaccess fuerza a que la web vaya sobre https

---------------------------------------------------------

