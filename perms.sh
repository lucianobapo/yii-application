#!/bin/sh
echo "dia $(date +%Y%m%d)"
chmod 750 -R ./
chgrp www-data -R ./
chown ubuntu -R ./
chmod 770 ./
chmod 770 -R images/
chmod 770 -R assets/
chmod 770 -R protected/runtime/
chmod 700 perms.sh
chmod 700 ftp-perms.sh
chmod 700 bacen.sh
chmod 700 mysql_dump.sh

