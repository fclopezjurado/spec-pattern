#!/bin/bash
# Maximum retries we want to iterate
MAX_RETRIES=10

retries=0
echo -n "Waiting MySQL to be ready"

# mysqladmin ping will produce false positives when is ready but can not yet accept.
# With this solution, we ensure the output is what we expect for any case.
until [[ "$o" == "mysqld is alive" ]]; do
  # Safeguard to avoid infinite loops
  ((retries=retries+1))
  if [ "$retries" -gt $MAX_RETRIES ]; then
    exit 1
  fi

  echo -n "."
  sleep 1

  o=$(docker-compose exec -T spec-pattern-db sh -c 'mysqladmin ping --no-beep 2> /dev/null')
done

# give some extra time to finish warming up in order to avoid random connection refusing
echo -n "hot standby."
sleep 2
echo -n ".all systems go"

echo -ne "\n"
exit 0
