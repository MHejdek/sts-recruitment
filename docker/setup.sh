#!/usr/bin/env bash

docker-compose build
docker-compose up -d
composer install -n
docker exec php ./bin/console doc:mig:mig --no-interaction

exec "$@"