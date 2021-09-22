#!/bin/bash

FILE="auto_start.sh"
cd /home/ec2-user

if [ -e $FILE ]; then
  source /home/ec2-user/.bash_profile
  export NVM_DIR="~/.nvm"
  su -l ec2-user -c "sudo sh ~/.nvm/nvm.sh" 
  npm install
  su -l ec2-user -c "sudo sh ~/auto_start.sh"
else
  cd /var/www
  composer update
  composer install
fi
