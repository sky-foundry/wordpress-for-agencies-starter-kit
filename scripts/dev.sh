#!/bin/bash

export LOCAL_IP=$(ifconfig | grep "inet " | grep -Fv 127.0.0.1 | awk 'NR==1{print $2}')

handle_signal () {
  docker-compose stop;
  exit;
}

trap_signals () {
  for signal in "$@"
  do
    trap "handle_signal" "$signal"
  done
}

trap_signals INT KILL STOP

docker-compose up -d && yarn --cwd web/app/themes/default-theme run dev --host $LOCAL_IP --disable-host-check;
