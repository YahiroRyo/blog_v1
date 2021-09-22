#!/bin/bash

FILE="auto_start.sh"
cd /home/ec2-user

if [ -e $FILE ]; then
  apt update
  apt install nodejs -y
  apt install npm -y
  npm i npm@latest -g
  npm i n -g
  npm install
  su -l ec2-user -c "sh ~/auto_start.sh"
else
  cd /var/www
  composer update
  composer install
fi
