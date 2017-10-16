#/bin/bash

#
# Project Post Setup Script
#
TITLE="Cloud Developer - v0.0.3 - Post Install"
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

" > $PWD/app/config.ini
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
    # */5 * * * * cd $PWD/bin && bash backup.sh
    #
    # With the idea.. in development backup every 5 mins, with the latest 
    #                 and then copy it to the daily if does not exist.
    
    mysqldump --user=\$db_user --password=\$db_pass --host=\$db_host \$db_name | gzip > $PWD/backups/current.sql.gz

    # Check if already backed up today
    if [ ! -f $PWD/backups/\$date.sql.gz ]; then
        # Dump database into SQL file
        cp $PWD/backups/current.sql.gz $PWD/backups/\$date.sql.gz
    fi

    # Delete files older than 7 days
    find $PWD/backups/*.sql.gz -mtime +7 -exec rm {} \;

    ##############################################################
    
} &> /dev/null" > $PWD/bin/backup.sh
}

main() {
    #
    whiptail --title "$TITLE" --msgbox "Please hit OK to complete setup." 0 0

    # Database Host
    until [[ $DBHOST != "" ]]; do
        DBHOST=$(whiptail --inputbox "Enter database host:" 8 70 "127.0.0.1" --title "$TITLE" 3>&1 1>&2 2>&3)
        exitstatus=$?
        if [ $exitstatus = 1 ]; then
            warn
        fi
    done
    
    # Database Database
    until [[ $DBNAME != "" ]]; do
        DBNAME=$(whiptail --inputbox "Enter database name:" 8 70 "" --title "$TITLE" 3>&1 1>&2 2>&3)
        exitstatus=$?
        if [ $exitstatus = 1 ]; then
            warn
        fi
    done
    
    # Database User
    until [[ $DBUSER != "" ]]; do
        DBUSER=$(whiptail --inputbox "Enter database username:" 8 70 "" --title "$TITLE" 3>&1 1>&2 2>&3)
        exitstatus=$?
        if [ $exitstatus = 1 ]; then
            warn
        fi
    done

    # Database Password
    until [[ $DBPASS != "" ]]; do
        DBPASS=$(whiptail --inputbox "Enter database password:" 8 70 "" --title "$TITLE" 3>&1 1>&2 2>&3)
        exitstatus=$?
        if [ $exitstatus = 1 ]; then
            warn
        fi
    done
    
    # import database
    cat $PWD/bin/database.sql | mysql --user=$DBUSER --password=$DBPASS $DBNAME
    
    # Generate plinker private key.
    PLINKER_KEY=$(date +%s | sha256sum | base64 | head -c 32 ; echo)

    # Write ./app/config.ini
    write_config $DBHOST $DBNAME $DBUSER $DBPASS $PLINKER_KEY

    # Write backup script
    write_backup_script $DBHOST $DBNAME $DBUSER $DBPASS

    # Write cron jobs
    crontab -l | { cat; echo -e "@reboot while sleep 1; do cd $PWD/tasks && /usr/bin/php $PWD/tasks/run.php ; done"; } | crontab -
    crontab -l | { cat; echo -e "0 0 * * * cd $PWD/bin && bash backup.sh"; } | crontab -
    
    # Add directorys & change ownership
    mkdir $PWD/tmp
    mkdir $PWD/tmp/template
    mkdir $PWD/backups
    
    # move starter template
    cp -R $PWD/app/template/starter/ $PWD/tmp/template/1
    mkdir $PWD/tmp/template/1/img
    
    # fix permissions
    chown www-data:www-data $PWD/ -R
    chmod 0775 $PWD/tmp
    
    # Run composer dump autoloader
    { 
        composer du
    } &> /dev/null

    # fin
    whiptail --title "$TITLE" --msgbox "Setup complete! Visit the script in your browser." 0 0
}

main