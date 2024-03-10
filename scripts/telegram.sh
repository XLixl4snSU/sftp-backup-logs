#!/bin/bash
if [ -z $telegram_chat_id ] || [ -z $telegram_bot_token ]; then
  echo "Telegram variables not set"
  exit 1
fi

if [ -z $webserver_url ] || [ -z $webserver_url ]; then
  echo "Webserver URL not set"
  exit 1
fi

log_folder=/var/www/html/logs/
regex="^(backup_script-)([[:digit:]]{4}-[[:digit:]]{2}-[[:digit:]]{2}).log\$"
send () {
  curl --data-urlencode "text=$message" "https://api.telegram.org/bot$telegram_bot_token/sendMessage?chat_id=$telegram_chat_id"
}


while true
do
  while [ ! -f $log_folder"backup_script-$(date +%F).log" ]
  do
    sleep 60
  done
  now_running_file=$log_folder"backup_script-$(date +%F).log"
  now_running_date=$(date +%F)
  message="New backup running now: $(date +%F)"
  send
  while true
  do
    if grep -q "Backup script finished successfully." $now_running_file; then
      message="✅✅✅ Backup of $now_running_date finished successfully! ✅✅✅"$'\n'"See $webserver_url/show-log?date=$now_running_date for logs."
      send
      break
    elif grep -q "Rsync reports an error." $log_folder$file; then
      message="⚠️⚠️⚠️ Backup $now_running_date failed! ⚠️⚠️⚠️"$'\n'"See $webserver_url/show-log?date=$now_running_date for logs."
      send
      break
    else
      sleep 10s
  done
done