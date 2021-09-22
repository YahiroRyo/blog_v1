#!/bin/bash

FILE="auto_start.sh"
cd /home/ec2-user

if [ -e $FILE ]; then
  export NVM_DIR="/home/ec2-user/.nvm" [ -s "$NVM_DIR/nvm.sh" ] && . "$NVM_DIR/nvm.sh"
  npm install
  su -l ec2-user -c "sh ~/auto_start.sh"
else
  cd /var/www
  composer update
  composer install
fi
