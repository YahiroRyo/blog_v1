#!/bin/bash

FILE="auto_start.sh"
cd /home/ec2-user

if [ -e $FILE ]; then
  npm install
else
  cd /var/www
  composer update
  composer install
fi
