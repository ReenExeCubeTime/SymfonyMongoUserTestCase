#!/usr/bin/env bash
sudo aptitude install -q -y -f php5-cli php5-curl

sudo apt-get install -y php-pear php5-dev
sudo apt-get install libsasl2-dev
sudo pecl install mongo
# You should add "extension=mongo.so" to php.ini