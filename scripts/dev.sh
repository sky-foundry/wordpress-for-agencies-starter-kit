#!/bin/bash

export LOCAL_IP=$(ifconfig | grep "inet " | grep -Fv 127.0.0.1 | awk '{print $2}')

handle_signal () {
  docker-compose stop;
  exit;
}

_trap () {
  for signal in "$@"
  do
    trap "handle_signal" "$signal"
  done
}

_trap INT KILL STOP

docker-compose up -d && yarn run encore dev-server --watch --host $LOCAL_IP --disable-host-check;
