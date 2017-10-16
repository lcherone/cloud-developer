#!/bin/bash

# Run composer update
/usr/local/bin/composer update -d /var/www/html/cloud-developer 2>&1

# Change files ownership to www-data user
chown www-data:www-data /var/www/html/cloud-developer/.* -R