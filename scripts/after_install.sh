#!/bin/bash

FILE = "auto_start.sh"

if [ -e $FILE ]; then
  # appの場合
  sudo mv /home/ec2-user/tmp/app/* /home/ec2-user/
  sudo mv /home/ec2-user/tmp/app/.* /home/ec2-user/
else
  # apiの場合
  sudo mv /home/ec2-user/tmp/api/* /var/www
  sudo mv /home/ec2-user/tmp/api/.* /var/www
fi