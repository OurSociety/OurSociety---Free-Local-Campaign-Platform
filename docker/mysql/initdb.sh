#!/usr/bin/env bash

set -e

# Set password variable for mysql CLI tool
export MYSQL_PWD=${MYSQL_ROOT_PASSWORD}

# Create app/test databases
DATABASES=( "app" "test" )
for DATABASE in "${DATABASES[@]}"
do
  mysql -u root -e "DROP DATABASE IF EXISTS ${DATABASE};"
  mysql -u root -e "CREATE DATABASE ${DATABASE};"
  mysql -u root -D "${DATABASE}" -e "GRANT ALL PRIVILEGES ON ${DATABASE}.* TO ${MYSQL_USER}@'%' IDENTIFIED BY '${MYSQL_PASSWORD}'"
done
