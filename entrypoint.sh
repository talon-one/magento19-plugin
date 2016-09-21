#!/bin/bash

set -e
set -o pipefail

echo "sleeping"
sleep 5

echo "create db"
mysql "-p$MYSQL_ROOT_PASSWORD" -h $MYSQL_HOST -t<<EOF
CREATE DATABASE IF NOT EXISTS $MYSQL_DATABASE;
GRANT ALL ON $MYSQL_DATABASE.* TO '$MYSQL_USER' IDENTIFIED BY '$MYSQL_PASSWORD';
EOF

# figure out if the database is initialized, both --silent flags are required to
table_count=$(
  mysql --skip-column-names \
    -u "$MYSQL_USER" "-p$MYSQL_PASSWORD" -h $MYSQL_HOST -D $MYSQL_DATABASE \
    -e "SELECT COUNT(DISTINCT table_name) FROM information_schema.columns WHERE table_schema = 'magento'"
)

if [ "$table_count" == "0" ]; then
  echo "install magento"
  php -f /var/www/htdocs/install.php -- \
  --license_agreement_accepted "yes" \
  --db_host $MYSQL_HOST \
  --db_name $MYSQL_DATABASE \
  --db_user $MYSQL_USER \
  --db_pass $MYSQL_PASSWORD \
  --locale $MAGENTO_LOCALE \
  --timezone $MAGENTO_TIMEZONE \
  --default_currency $MAGENTO_DEFAULT_CURRENCY \
  --url $MAGENTO_URL \
  --admin_firstname $MAGENTO_ADMIN_FIRSTNAME \
  --admin_lastname $MAGENTO_ADMIN_LASTNAME \
  --admin_email $MAGENTO_ADMIN_EMAIL \
  --admin_username $MAGENTO_ADMIN_USERNAME \
  --admin_password $MAGENTO_ADMIN_PASSWORD \
  --use_secure_admin "no" \
  --use_secure "no" \
  --secure_base_url "" \
  --skip_url_validation "yes" \
  --use_rewrites "no"
fi

exec apache2-foreground
