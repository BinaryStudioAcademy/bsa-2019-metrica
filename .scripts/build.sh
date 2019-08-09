#!/bin/bash

DOCKER_IMAGE=$1

docker build --build-arg UID=$UID --build-arg GID=$GID -t metrica/$DOCKER_IMAGE:latest -f .aws/$DOCKER_IMAGE/Dockerfile .
