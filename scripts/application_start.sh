#!/bin/bash

FILE="auto_start.sh"
cd /home/ec2-user

if [ -e $FILE ]; then
  source /home/ec2-user/.bash_profile
  npm install
else
  cd /var/www
  composer update
  composer install
  sudo chmod 777 -R *
fi
