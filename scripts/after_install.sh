#!/bin/bash

FILE="auto_start.sh"
cd /home/ec2-user

if [ -e $FILE ]; then
  # appの場合
  sudo rm -rf /home/ec2-user/*
  sudo mv -f /var/tmp/app/* /home/ec2-user/
  dd if=/dev/zero of=/swapfile bs=1M count=1024
  chmod 600 /swapfile
  mkswap /swapfile
  swapon /swapfile
else
  # apiの場合
  sudo rm -rf /var/www/*
  sudo mv -f /var/tmp/api/* /var/www/
fi
