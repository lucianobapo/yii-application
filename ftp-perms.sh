#!/bin/sh
echo "dia $(date +%Y%m%d)"
chmod 770 -R /var/www/appyii_v1/
chgrp ftp-user -R /var/www/appyii_v1/
chown root -R /var/www/appyii_v1/

