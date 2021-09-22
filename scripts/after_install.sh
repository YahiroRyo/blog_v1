#!/bin/bash

FILE="auto_start.sh"
cd /home/ec2-user

if [ -e $FILE ]; then
  # appの場合
  export NVM_DIR="$HOME/.nvm"
  [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"  # This loads nvm
  [ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"  # This loads nvm bash_completion
  sudo rm -rf /home/ec2-user/*
  sudo mv -f /var/tmp/app/* /home/ec2-user/
else
  # apiの場合
  sudo rm -rf /var/www/*
  sudo mv -f /var/tmp/api/* /var/www/
fi
