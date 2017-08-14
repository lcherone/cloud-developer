#!/bin/bash

 #whiptail --title "$TITLE" --infobox "Writing ./app/config.ini file." 0 0
    echo "
[globals]

meta.name=\"Cloud Developer\"
meta.description=\"\"
meta.author=\"Lawrence Cherone\"

; database
db.dsn=\"mysql:host=$DBHOST;dbname=$DBNAME\"
db.username=\"$DBUSER\"
db.password=\"$DBPASS\"
db.freeze=false
db.debug=false

; plinker
plinker.enabled=true
plinker.private_key=\"$PLINKER_KEY\"

; framework
BASE=
CACHE=false
DEBUG=3
AUTOLOAD=\"app/\"

" > `pwd`/app/config.ini

    #whiptail --title "$TITLE" --infobox "Writing ./bin/backup.sh file." 0 0
    echo "#!/bin/bash

#
## Database Backup script
## Author: @lcherone <lawrence@cherone.co.uk>
#

PATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin
export DISPLAY=:0.0

# Database credentials
user=\"$DBUSER\"
password=\"$DBPASS\"
host=\"$DBHOST\"
db_name=\"$DBNAME\"

# Set paths ect
date=\$(date +\"%d-%b-%Y\")

# Wrap logic to catch console output
{
    ##############################################################
    # - Start database dump latest
    #
    # In cron we are doing:
    # */5 * * * * cd `pwd`/bin && bash backup.sh
    #
    # With the idea.. in development backup every 5 mins, with the latest 
    #                 and then copy it to the daily if does not exist.
    
    mysqldump --user=\$user --password=\$password --host=\$host \$db_name | gzip > `pwd`/backups/current.sql.gz

    # Check if already backed up today
    if [ ! -f `pwd`/backups/\$date.sql.gz ]; then
        # Dump database into SQL file
        cp `pwd`/backups/current.sql.gz /var/www/html/backups/\$date.sql.gz
    fi

    # Delete files older than 7 days
    find `pwd`/backups/*.sql.gz -mtime +7 -exec rm {} \;

    ##############################################################
    
} &> /dev/null
" > `pwd`/bin/backup.sh
