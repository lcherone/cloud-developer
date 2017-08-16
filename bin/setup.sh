#/bin/bash

#
# Project Post Setup Script
#
TITLE="Cloud Developer - v0.0.2 - Post Install"
TERM=vt220
PWD=$(pwd)

warn() {
    #
    whiptail --title "$TITLE" --msgbox "You must complete setup or the script will not work." 0 0
}

write_config() {
    #
    echo -e "[globals]

meta.name=\"Cloud Developer\"
meta.description=\"\"
meta.author=\"Lawrence Cherone\"

; database
db.host=\"$1\"
db.name=\"$2\"
db.username=\"$3\"
db.password=\"$4\"
db.freeze=false
db.debug=false

; plinker
plinker.enabled=true
plinker.private_key=\"$5\"

; framework
BASE=
CACHE=false
DEBUG=3
AUTOLOAD=\"app/\"

" > $6/app/config.ini
}

write_backup_script() {
    echo -e "#!/bin/bash

#
## Database Backup script
## Author: @lcherone <lawrence@cherone.co.uk>
#

PATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin
export DISPLAY=:0.0

# Database credentials
db_host=\"$1\"
db_name=\"$2\"
db_user=\"$3\"
db_pass=\"$4\"

# Set paths ect
date=\$(date +\"%d-%b-%Y\")

# Wrap logic to catch console output
{
    ##############################################################
    # - Start database dump
    #
    # In cron we are doing:
    # */5 * * * * cd $5/bin && bash backup.sh
    #
    # With the idea.. in development backup every 5 mins, with the latest 
    #                 and then copy it to the daily if does not exist.
    
    mysqldump --user=\$user --password=\$password --host=\$host \$db_name | gzip > $5/backups/current.sql.gz

    # Check if already backed up today
    if [ ! -f $5/backups/\$date.sql.gz ]; then
        # Dump database into SQL file
        cp $5/backups/current.sql.gz $5/backups/\$date.sql.gz
    fi

    # Delete files older than 7 days
    find $5/backups/*.sql.gz -mtime +7 -exec rm {} \;

    ##############################################################
    
} &> /dev/null
" > $5/bin/backup.sh
}

main() {
    #
    whiptail --title "$TITLE" --msgbox "Please hit OK to complete setup." 0 0

    # Database Host
    DBHOST=$(whiptail --inputbox "Enter database host:" 8 70 "127.0.0.1" --title "$TITLE" 3>&1 1>&2 2>&3)
    exitstatus=$?
    if [ $exitstatus = 1 ]; then
        warn
    fi
    
    # Database Database
    DBNAME=$(whiptail --inputbox "Enter database name:" 8 70 "" --title "$TITLE" 3>&1 1>&2 2>&3)
    exitstatus=$?
    if [ $exitstatus = 1 ]; then
        warn
    fi
    
    # Database User
    DBUSER=$(whiptail --inputbox "Enter database username:" 8 70 "" --title "$TITLE" 3>&1 1>&2 2>&3)
    exitstatus=$?
    if [ $exitstatus = 1 ]; then
        warn
    fi
    
    # Database Password
    DBPASS=$(whiptail --inputbox "Enter database password:" 8 70 "" --title "$TITLE" 3>&1 1>&2 2>&3)
    exitstatus=$?
    if [ $exitstatus = 1 ]; then
        warn
    fi
    
    #whiptail --title "$TITLE" --infobox "Generating plinker private key." 0 0
    PLINKER_KEY=$(date +%s | sha256sum | base64 | head -c 32 ; echo)

    #whiptail --title "$TITLE" --infobox "Writing ./app/config.ini file." 0 0
    write_config $DBHOST $DBNAME $DBUSER $DBPASS $PLINKER_KEY $PWD

    #whiptail --title "$TITLE" --infobox "Writing ./bin/backup.sh file." 0 0
    write_backup_script $DBHOST $DBNAME $DBUSER $DBPASS $PWD

    #whiptail --title "$TITLE" --infobox "Adding CRON task" 0 0
    crontab -l | { cat; echo "\n* * * * * cd $PWD/tasks && /usr/bin/php $PWD/tasks/run.php >/dev/null 2>&1"; } | crontab -
    crontab -l | { cat; echo "\n0 0 * * * cd $PWD/bin && bash backup.sh"; } | crontab -
    
    # fin
    whiptail --title "$TITLE" --msgbox "Setup complete!" 0 0
}

main