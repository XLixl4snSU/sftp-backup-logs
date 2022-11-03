#!/bin/bash
if [ -z $telegram_chat_id ] || [ -z $telegram_bot_token ]; then
  echo "Telegram variables not set"
  exit 1
fi
log_folder=/var/www/html/logs/
regex="^(backup_script-)([[:digit:]]{4}-[[:digit:]]{2}-[[:digit:]]{2}).log\$"
send() {
  curl --data-urlencode "text=$message" "https://api.telegram.org/bot$telegram_bot_token/sendMessage?chat_id=$telegram_chat_id"
}
last_file=""
file_list=$(ls $log_folder)
inotifywait -m $log_folder -e create -e moved_to |
  while read dir action file; do
    if [[ ! $file_list =~ $file ]]; then
      if [[ $last_file != $file ]]; then
        last_file=$file
        if [[ $file =~ $regex ]]; then
          backup_date_original=${BASH_REMATCH[2]}
          backup_date=$(date -d "$backup_date_original" +"%d.%m.%Y")
          message="New backup running now: $backup_date"
          send
          while true; do
            if grep -q "Backup script finished successfully." $log_folder$file; then
              message="✅✅✅ Backup of $backup_date finished successfully! ✅✅✅"$'\n'"See https://logs.fllx.de/show-log?date=$backup_date_original for logs."
              send
              break
            elif grep -q "Rsync reports an error." $log_folder$file; then
              message="⚠️⚠️⚠️ Backup $backup_date failed! ⚠️⚠️⚠️"$'\n'"See https://logs.fllx.de/show-log?date=$backup_date_original for logs."
              send
              break
            else
              sleep 10s
            fi
          done
        fi
      fi
    fi
    file_list=$(ls)
  done
