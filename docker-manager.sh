#!/bin/bash

source "$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )/.config.sh"

function help() {
    echo "Usage $0 [-s|-u|-c|-r|-rf|-h]";
    echo "-s shutdown containers";
    echo "-u start containers";
    echo "-c access to the app container console";
    echo "-r reset app container, no data will lost";
    echo "-rf reset all mapped container AND delete all data except php project dir files";
    echo "-h show help";
    exit 0;
}

if [ "$1" == "-h" ]; then
    help;
fi

if [ ! -e $DOCKER_COMPOSE_PATH ]; then
    echo -e "File $DOCKER_COMPOSE_PATH non trovato";
    exit 1;
fi

if [ ! -e $DOCKER_COMPOSE_OVERRIDE_PATH ]; then
    echo -e "File $DOCKER_COMPOSE_OVERRIDE_PATH non trovato";
    exit 1;
fi

if [ "$1" == "-s" ]; then
    $DOCKER_COMPOSE_COMMAND stop;
    exit 0;
fi

if [ "$1" == "-u" ]; then
    $DOCKER_COMPOSE_COMMAND up -d;
#    if [ -f ~/.gitconfig ]; then
#        sudo docker cp ~/.gitconfig docker_$(echo $APP_CONTAINER_NAME)_1:/home/application/.gitconfig
#        sudo docker exec --user root -it docker_$(echo $APP_CONTAINER_NAME)_1 chown -R application:application /home/application/.gitconfig
#    fi

    sudo docker exec --user application -it docker_$(echo $APP_CONTAINER_NAME)_1 composer install

    echo "";
    echo "IP: 10.10.254.2";

    exit 0;
fi

if [ "$1" == "-uforce" ]; then
    $DOCKER_COMPOSE_COMMAND up -d --force-recreate;
#    if [ -f ~/.gitconfig ]; then
#        sudo docker cp ~/.gitconfig docker_$(echo $APP_CONTAINER_NAME)_1:/home/application/.gitconfig
#        sudo docker exec --user root -it docker_$(echo $APP_CONTAINER_NAME)_1 chown -R application:application /home/application/.gitconfig
#    fi

    sudo docker exec --user application -it docker_$(echo $APP_CONTAINER_NAME)_1 composer install

    echo "";
    echo "IP: 10.10.254.2";

    exit 0;
fi

if [ "$1" == "-croot" ]; then
    sudo docker exec --user root -it docker_$(echo $APP_CONTAINER_NAME)_1 bash
    exit 0;
fi

if [ "$1" == "-c" ]; then
    sudo docker exec --user application -it docker_$(echo $APP_CONTAINER_NAME)_1 bash
    exit 0;
fi

if [ "$1" == "--mysql-console" ]; then
    sudo docker exec --user root -it $(echo "docker_mysql_test_1") bash
    exit 0;
fi

if [ "$1" == "--backup" ]; then
    if [ -z "$2" ]; then
        echo "Specificare il nome del database"
        exit 0;
    fi
    sudo ./docker/bin/backup.sh $2
    exit 0;
fi

if [ "$1" == "--backup-all" ]; then
    sudo ./docker/bin/backup.sh
    exit 0;
fi

if [ "$1" == "--restore-backup" ]; then
    sudo ./docker/bin/restore.sh
    exit 0;
fi

if [ "$1" == "-r" ]; then
    $DOCKER_COMPOSE_COMMAND stop;
    $DOCKER_COMPOSE_COMMAND rm --force $APP_CONTAINER_NAME;
    $DOCKER_COMPOSE_COMMAND build --no-cache $APP_CONTAINER_NAME;
    $DOCKER_COMPOSE_COMMAND up -d;
    if [ -f ~/.gitconfig ]; then
        sudo docker cp ~/.gitconfig docker_$(echo $APP_CONTAINER_NAME)_1:/home/application/.gitconfig
        sudo docker exec --user root -it docker_$(echo $APP_CONTAINER_NAME)_1 chown -R application:application /home/application/.gitconfig
    fi
    exit 0;
fi

if [ "$1" == "-rf" ]; then
    $DOCKER_COMPOSE_COMMAND stop;
    $DOCKER_COMPOSE_COMMAND rm --force;
    $DOCKER_COMPOSE_COMMAND build --no-cache;
    $DOCKER_COMPOSE_COMMAND up -d;
    if [ -f ~/.gitconfig ]; then
        sudo docker cp ~/.gitconfig docker_$(echo $APP_CONTAINER_NAME)_1:/home/application/.gitconfig
        sudo docker exec --user root -it docker_$(echo $APP_CONTAINER_NAME)_1 chown -R application:application /home/application/.gitconfig
    fi
    exit 0;
fi

help;
exit 0;
