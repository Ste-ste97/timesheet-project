#!/bin/bash
echo -n "This script is about to rebuild the project. All data will be lost are you sure? (y/n)"
read answer
if [ "$answer" != "${answer#[Yy]}" ] ;then
    docker-compose build
    docker-compose up -d
    echo "Done with docker"
    sudo chmod u+x composer.sh
    ./composer.sh install
    sudo chmod o+w -R storage/
    cp .env.docker .env
    sudo chmod u+x artisan.sh
    ./artisan.sh key:generate
    sudo chmod u+x yarn.sh
    ./yarn.sh install
    ./yarn.sh run prod
    ./artisan.sh migrate:fresh --seed
    echo "Done with everything, enjoy!"
else
    echo "Okay bye!"
fi
