#!/usr/bin/env bash
# hackOx installer

main() {
  if [ "$EUID" -ne 0 ]
    then 
      echo "----= hackOx installer =----"
      echo "Please run installer as root"
    exit
  fi
  
  # Create hackOx env
  echo "Creating hackOx environment..."
  mkdir /var/hackox
  tempfile=/var/hackox/latest.zip
  workspace=/var/hackox
  
  # Create user
  groupadd hackox
  useradd -g hackox hackox
  
  # Add user to sudoers file 
  echo "hackox ALL=NOPASSWD: ALL" > /etc/sudoers.d/hackox
  
  cd /var/hackox
  
  # Download latest release
  echo "Installing latest release..."
  wget https://repo.hackox.net/client/hackox-latest-stable.zip
  unzip -oq ${tempfile} -d ${workspace}
  rm -rf ${tempfile}
  
  # Directory permissions
  chown -R hackox:hackox /var/hackox
  chmod -R g+rw /var/hackox
  
  # Install dependencies
  echo "Installing dependencies..."
  apt-get -y install apache2 apache2-mpm-itk php5-curl mysql-server cURL wput cron wget sudo wpasupplicant
  
  # Enable Apache2 Mods
  cd /etc/apache2/sites-available/
  a2enmod -q rewrite
  a2enmod -q mpm_itk
  service apache2 restart
  
  # Add VirtualHost
  a2ensite -q hackox.conf
  service apache2 restart
  
  # Update motd
  cat /var/hackox/motd > /etc/motd
  
  echo '   +m.                           +m.     '
  echo '   mdm`                         :Nmo     '
  echo '  :N`hh                        .N//N     '
  echo '  hy `mo                      `ds  N/    '
  echo '  yy  .No-   `-:+ooooo/:.   `:hh  `N/    '
  echo '  `ds  `:oyyyyo/-.....:+oyyyy+-  .ms     '
  echo '   `yd-                         /m/      '
  echo '  `+ydy-                       +hds:     '
  echo '  .yd+..-/o`               :+:-`-sdo     '
  echo '    `/ss++M.               om/oso-       '
  echo '         -M`               +m            '
  echo '          yh.             :m/   █                    █      ▀▀▀▀▀▀▀▀█         '
  echo '           /m/          `yd.    █ ▄▄▄▄ ▄▄▄▄▄▄ ▄▄▄▄▄▄ █    ▄         █ ▄▄ ▄▄▄▄ '
  echo '            .N/         hh      █    █ █    █ █      █▄▄▄▄▄ █       █    █    '
  echo '             ms        `ds      █    █ █▄▄▄ █ █▄▄▄▄▄ █    █ █▄▄▄▄▄▄▄█ ▄▄▄█ ▄▄ '
  echo '             `sd/`   .om/                                                     '
  echo '               `osyyys/         v0.9.1 by @deantonious - hackox.net           '
  echo 
  echo '...is now installed! Please open http://localhost:8085/install to install the DB!'
  echo 
  echo 'Follow us at https://twitter.com/hackOx_dev.'
}

main