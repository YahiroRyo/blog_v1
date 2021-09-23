#!/bin/bash

FILE="auto_start.sh"
cd /home/ec2-user

if [ -e $FILE ]; then
  source /home/ec2-user/.bash_profile
  sudo su
  dd if=/dev/zero of=/swapfile bs=1M count=1024
  chmod 600 /swapfile
  mkswap /swapfile
  swapon /swapfile
  exit
  npm install
else
  cd /var/www
  composer update
  composer install
fi
