#Create user
groupadd hackox
useradd -g hackox hackox

#Add user to sudoers file 
echo "hackox ALL=NOPASSWD: ALL" > /etc/sudoers.d/hackox

#Create hackOx env
#TODO: create and setup /var/hackox

#Directory permissions
chown -R hackox:hackox /var/hackox
chmod -R g+rw /var/hackox

#Install dependencies
apt-get -y install apache2 apache2-mpm-itk php5-curl mysql-server cURL wput cron wget sudo wpasupplicant

#Enable Apache2 Mods
a2enmod rewrite
a2enmod mpm_itk
service apache2 restart

#Add VirtualHost
#TODO: add VH file to /etc/apache2/sites-available/hackox.conf
a2ensite hackox.conf
service apache2 restart
