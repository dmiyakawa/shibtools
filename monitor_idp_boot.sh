#!/bin/bash

set -u

first_ts=$(date '+%s')
total_tries=0
allowed_tries=60
while true; do
  total_tries=$(($total_tries+1))
  # result=`wget -q -O - --no-check-certificate https://localhost/idp/profile/Status`
  result=`wget -q -O - --no-check-certificate https://localhost/idp/status`
  if [[ -n "${result}" ]]; then
    echo ${result}
    break;
  fi
  if [[ $total_tries -gt $allowed_tries ]]; then
    echo "Time Limit Exceeded"
    exit 1
  fi
  idp_ts=$(ls -l --time-style='+%s' /opt/shibboleth-idp/logs/idp-process.log | awk '{print $5}')
  # If IdP's last log is after when this command is executed.
  if [[ $(expr ${idp_ts} - ${first_ts}) -gt 0 ]]; then
    # Show a line number with -n
    # e.g. "1064:10:58:02.616 - ERROR [edu.internet2.middl .."
    line=$(grep -n ERROR /opt/shibboleth-idp/logs/idp-process.log | tail -n1)
    if [[ -n $line ]]; then
      # Obtain the first line number
      ln=$(echo $line | sed 's/^\([0-9]\+\).\(.*$\)/\1/')
      # Restore the original line and get timestamp out of it.
      severe_log_ts=$(date -d "$(echo $line | sed 's/^\([0-9]\+\).\(.*\)$/\2/' | cut -c-13)" '+%s')
      diff=$(expr ${severe_log_ts} - ${first_ts})
      if [[ $diff -gt -5 ]]; then
        tail -n"+$ln" /opt/shibboleth-idp/logs/idp-process.log
        echo "!!!!!!!!!!!!!!!!!!!!!!"
        echo "***Idp seems angry***"
        echo "!!!!!!!!!!!!!!!!!!!!!!"
        exit 1
      fi
    fi
  fi

  line=$(grep -n --no-group-separator -B1 SEVERE /usr/java/tomcat/logs/catalina.out | awk 'NR%2==1' | tail -n1)
  if [[ -n $line ]]; then
    ln=$(echo $line | sed 's/^\([0-9]\+\)..*$/\1/')
    severe_log_ts=$(date -d "$(echo $line | sed 's/^[0-9]\+.\(.*\)$/\1/' | cut -c-13)" '+%s')
    diff=$(expr ${severe_log_ts} - ${first_ts})
    if [[ $diff -gt -5 ]]; then
      tail -n"+$ln" /opt/shibboleth-idp/logs/idp-process.log
      echo "!!!!!!!!!!!!!!!!!!!!!!!!"
      echo "***Tomcat seems angry***"
      echo "!!!!!!!!!!!!!!!!!!!!!!!!"
      exit 1
    fi
  fi
  sleep 1
  echo -n "."
  if [[ $(expr $total_tries % 20) -eq 0 ]]; then
    echo
  fi
done
