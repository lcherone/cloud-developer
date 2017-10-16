#!/bin/bash

#
## Database Backup script
## Author: @lcherone <lawrence@cherone.co.uk>
#

PATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin
export DISPLAY=:0.0

# Database credentials
db_host="127.0.0.1"
db_name="app"
db_user="app"
db_pass="lsAZ0XEX5Kk5q9QnSUzqa1bVaFOxHF7b"

# Set paths ect
date=$(date +"%d-%b-%Y")

# Wrap logic to catch console output
{
    ##############################################################
    # - Start database dump
    #
    # In cron we are doing:
    # */5 * * * * cd /var/www/html/cloud-developer/bin && bash backup.sh
    #
    # With the idea.. in development backup every 5 mins, with the latest 
    #                 and then copy it to the daily if does not exist.
    
    mysqldump --user=$db_user --password=$db_pass --host=$db_host $db_name | gzip > /var/www/html/cloud-developer/backups/current.sql.gz

    # Check if already backed up today
    if [ ! -f /var/www/html/cloud-developer/backups/$date.sql.gz ]; then
        # Dump database into SQL file
        cp /var/www/html/cloud-developer/backups/current.sql.gz /var/www/html/cloud-developer/backups/$date.sql.gz
    fi

    # Delete files older than 7 days
    find /var/www/html/cloud-developer/backups/*.sql.gz -mtime +7 -exec rm {} \;

    ##############################################################
    
} &> /dev/null
