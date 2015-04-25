#!/bin/sh
echo "dia $(date +%Y%m%d)"
wget -P /var/www/appyii_v1/protected/data http://www4.bcb.gov.br/Download/fechamento/`date +%Y%m%d`.csv
