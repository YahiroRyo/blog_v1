source /home/ec2-user/.bash_profile

FILE="auto_start.sh"
cd /home/ec2-user

if [ -e $FILE ]; then
  
  npm install
  su -l ec2-user -c "sh ~/auto_start.sh"
else
  cd /var/www
  composer update
  composer install
fi
