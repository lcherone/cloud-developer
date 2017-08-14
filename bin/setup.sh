#/bin/bash

#
# Project Post Setup Script
#
TITLE="Cloud Developer - v0.0.1 - Post Install"
TERM=vt220

warn() {
    #
    whiptail --title "$TITLE" --msgbox "You must complete setup or the script will not work." 0 0
}

main() {
    #
    whiptail --title "$TITLE" --msgbox "Please hit OK to complete setup." 0 0
    
    # Check for wkhtmltopdf
    if [ $(dpkg-query -W -f='${Status}' wkhtmltopdf 2>/dev/null | grep -c "ok installed") -eq 0 ];
    then
        whiptail --title "$TITLE" --msgbox "wkhtmltopdf needs to be installed." 0 0
        whiptail --title "$TITLE" --infobox "Installing package: wkhtmltopdf" 0 0
        sudo apt-get install -yq wkhtmltopdf
    fi
    
    # Check for libfontconfig1
    if [ $(dpkg-query -W -f='${Status}' libfontconfig1 2>/dev/null | grep -c "ok installed") -eq 0 ];
    then
        whiptail --title "$TITLE" --msgbox "libfontconfig1 needs to be installed." 0 0
        whiptail --title "$TITLE" --infobox "Installing package: libfontconfig1" 0 0
        sudo apt-get install -yq libfontconfig1
    fi
        
    # Check for libxrender1
    if [ $(dpkg-query -W -f='${Status}' libxrender1 2>/dev/null | grep -c "ok installed") -eq 0 ];
    then
        whiptail --title "$TITLE" --msgbox "libxrender1 needs to be installed." 0 0
        whiptail --title "$TITLE" --infobox "Installing package: libxrender1" 0 0
        apt-get install -yq libxrender1
    fi
    
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
    PLINKER_KEY=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1)

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

    #
    #whiptail --title "$TITLE" --infobox "Changing file ownership $USER:$USER" 0 0
    chown $USER:$USER `pwd`/ -R
    
    #
    #whiptail --title "$TITLE" --infobox "Adding CRON task" 0 0
    crontab -l | { cat; echo "\n* * * * * cd `pwd`/tasks && /usr/bin/php `pwd`/tasks/run.php >/dev/null 2>&1"; } | crontab -
    crontab -l | { cat; echo "\n*/5 * * * * cd `pwd`/bin && bash backup.sh"; } | crontab -
    
    whiptail --title "$TITLE" --msgbox "Setup complete!" 0 0
    
    exit
}

main
