#!/bin/sh
set -eu

mysql --default-character-set=utf8mb4 \
  -uroot \
  -p"${MYSQL_ROOT_PASSWORD}" \
  "${MYSQL_DATABASE}" < /opt/import/eyoucms.sql
