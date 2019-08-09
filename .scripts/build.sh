#!/bin/bash

DOCKER_IMAGE=$1

docker build --build-arg UID=$(id -u) --build-arg GID=$(id -u) -t metrica/$DOCKER_IMAGE:latest -f .aws/$DOCKER_IMAGE/Dockerfile .
