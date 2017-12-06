#!/bin/bash

echo -n MySQL Username:
read username
echo -n MySQL Password:
stty -echo
read password
stty echo
# Run Command
echo
mysql -u$username  -p$password < db.sql 2>/dev/null

composer install


CURRENT=`pwd`
BASENAME=`basename "$CURRENT"`

URL=$(echo "$BASENAME" | tr '[:upper:]' '[:lower:]')

count=$(grep $BASENAME /etc/apache2/sites-available/default.conf | wc -l)
#echo $count
#echo $URL
if [ $count -gt 0 ]
then
    echo already exists
else
    cat << EOF | sudo tee -a /etc/apache2/sites-available/default.conf
<VirtualHost *:80>
    DocumentRoot /var/www/app/$BASENAME/public
    ServerName $URL.dev
</VirtualHost>
EOF
    sudo apache2ctl graceful 2>/dev/null
    sudo service apache2 stop 2>/dev/null
    sudo service apache2 start 2>/dev/null
fi
