#!/bin/bash

shutdown () {
  echo "Stopping container..."
  echo
  exit 0
}

trap shutdown SIGTERM SIGINT
echo "Starting nginx"
nginx
echo "Starting php"
php-fpm82
echo "Starting Telegram-Bot-Script"
/home/scripts/telegram.sh &
wait $!
