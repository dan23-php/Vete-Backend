#!/usr/bin/env bash
set -e

MAX_RETRIES=30
SLEEP=2
i=0

echo "Checking DB connectivity..."
while [ $i -lt $MAX_RETRIES ]; do
  if php artisan migrate:status > /dev/null 2>&1; then
    echo "DB is ready."
    exit 0
  fi
  i=$((i+1))
  echo "DB not ready yet ($i/$MAX_RETRIES) — sleeping $SLEEP s..."
  sleep $SLEEP
done

echo "Timed out waiting for DB."
exit 1
