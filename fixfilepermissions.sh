#!/bin/bash

user=`whoami`

echo "Benutzer ist $user"
read -p "Fortfahren?"

sudo chown $user:www-data storage/logs
sudo chmod g+w storage/logs
sudo chown $user:www-data storage/logs/*
sudo chmod g+w storage/logs/*

sudo chown $user:www-data bootstrap/cache
sudo chmod g+w bootstrap/cache
sudo chown $user:www-data bootstrap/cache/*
sudo chmod g+w bootstrap/cache/*

sudo chown $user:www-data storage/framework
sudo chmod g+w storage/framework
sudo chown $user:www-data storage/framework/views
sudo chmod g+w storage/framework/views
sudo chown $user:www-data storage/framework/sessions/
sudo chmod g+w storage/framework/sessions/

sudo chown $user:www-data storage/framework/views/*
sudo chmod g+w storage/framework/views/*
sudo chown $user:www-data storage/framework/sessions/*
sudo chmod g+w storage/framework/sessions/*
