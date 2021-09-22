#!/bin/bash

FILE="auto_start.sh"
cd /home/ec2-user

if [ -e $FILE ]; then
  export NVM_DIR="$HOME/.nvm"
  su -l ec2-user -c "sudo sh $NVM_DIR/nvm.sh" 
  su -l ec2-user -c "sudo sh ~/auto_start.sh"
else
  cd /var/www
  composer update
  composer install
fi
