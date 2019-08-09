#!/bin/bash

DOCKER_IMAGE=$1

docker build --build-arg=$UID --build-arg=$GID -t metrica/$DOCKER_IMAGE:latest -f .aws/$DOCKER_IMAGE/Dockerfile .
