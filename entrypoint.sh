#!/bin/bash

set -e
set -o pipefail

# Fixup htaccess file to work correctly behind SSL termination proxy.
cat <<EOF >> /var/www/htdocs/.htaccess

# Detect the X-Forwarded-Proto header and set the \$_SERVER['HTTPS'] env var Magento expects
SetEnvIf X-Forwarded-Proto https HTTPS=on
EOF

if [ -f /persistent/local.xml ]; then
  cp /persistent/local.xml /var/www/htdocs/app/etc/local.xml
fi

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
  --use_rewrites "no" \
  || true # Allow this install script to fail.

if [ ! -f /persistent/local.xml ]; then
  cp /var/www/htdocs/app/etc/local.xml /persistent/local.xml
fi

exec apache2-foreground
