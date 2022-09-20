#!/bin/bash

APP_CONTAINER_NAME="app_test"
MYSQL_CONTAINER_NAME="mysql_test"
DOCKER_COMPOSE_PATH="$(pwd)/docker/docker-compose-linux.yml";
DOCKER_COMPOSE_COMMAND="sudo docker-compose -f $DOCKER_COMPOSE_PATH "
