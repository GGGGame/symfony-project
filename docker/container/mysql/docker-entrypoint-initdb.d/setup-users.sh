#!/bin/bash

mysql -uroot -p${MYSQL_ROOT_PASSWORD} -h localhost -e "GRANT ALL PRIVILEGES ON *.* TO root@'%';"
mysql -uroot -p${MYSQL_ROOT_PASSWORD} -h localhost -e "ALTER USER 'root'@'%' IDENTIFIED BY '${MYSQL_ROOT_PASSWORD}';"
mysql -uroot -p${MYSQL_ROOT_PASSWORD} -h localhost -e "FLUSH PRIVILEGES;"