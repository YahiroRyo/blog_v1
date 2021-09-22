#!/bin/bash

FILE="auto_start.sh"
cd /home/ec2-user

if [ -e $FILE ]; then
  source /home/ec2-user/.bash_profile
  node --max-old-space-size=1000 $(which npm) install
  sudo sh ~/auto_start.sh
else
  cd /var/www
  composer update
  composer install
fi
