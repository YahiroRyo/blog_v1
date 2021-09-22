#!/bin/bash

FILE="auto_start.sh"
cd /home/ec2-user

if [ -e $FILE ]; then
  if [[ -s ~/.nvm/nvm.sh ]] ; then
    source ~/.nvm/nvm.sh ;
  fi
  npm install
  su -l ec2-user -c "sh ~/auto_start.sh"
else
  cd /var/www
  composer update
  composer install
fi