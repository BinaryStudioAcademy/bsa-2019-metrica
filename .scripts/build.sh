#!/bin/bash

DOCKER_IMAGE=$1

docker build -t metrica/$DOCKER_IMAGE:latest -f .aws/$DOCKER_IMAGE/Dockerfile .
