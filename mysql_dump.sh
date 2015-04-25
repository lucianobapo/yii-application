#!/bin/sh
echo "dia $(date +%Y%m%d)"
mysqldump -u dump -pdump yii-database > /var/www/appyii_v1/protected/data/`date +%Y%m%d`.sql
