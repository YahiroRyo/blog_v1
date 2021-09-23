#!/bin/bash

FILE="auto_start.sh"
cd /home/ec2-user

if [ -e $FILE ]; then
  # appの場合
  sudo rm -rf /home/ec2-user/*
  sudo mv -f /var/tmp/app/* /home/ec2-user/
else
  # apiの場合
  sudo rm -rf /var/www/*
  sudo mv -f /var/tmp/api/* /var/www/
fi
