#!/bin/sh
echo "dia $(date +%Y%m%d)"
chmod 750 -R /var/www/appyii_v1/
chgrp www-data -R /var/www/appyii_v1/
chown luciano -R /var/www/appyii_v1/
chmod 770 /var/www/appyii_v1/
chmod 770 /var/www/appyii_v1/images/
chmod 770 -R /var/www/appyii_v1/assets/
chmod 770 -R /var/www/appyii_v1/protected/runtime/
chmod 770 -R /var/www/appyii_v1/.git/
chmod 770 /var/www/appyii_v1/git-add.sh
chmod 700 /var/www/appyii_v1/perms.sh
chmod 700 /var/www/appyii_v1/ftp-perms.sh
chmod 700 /var/www/appyii_v1/bacen.sh
chmod 700 /var/www/appyii_v1/mysql_dump.sh

