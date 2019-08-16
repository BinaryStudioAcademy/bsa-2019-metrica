# BSA 2019 | PHP | Metrica

[![Build Status](https://travis-ci.org/BinaryStudioAcademy/bsa-2019-metrica.svg?branch=master)](https://travis-ci.org/BinaryStudioAcademy/bsa-2019-metrica)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/863afc2d9c034b33ae2e0b49827e19fa)](https://www.codacy.com/app/lenchvolodymyr/bsa-2019-metrica?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=BinaryStudioAcademy/bsa-2019-metrica&amp;utm_campaign=Badge_Grade)
[![StyleCI](https://github.styleci.io/repos/199579591/shield?branch=develop)](https://github.styleci.io/repos/199579591)
[![License: MIT](https://img.shields.io/badge/License-MIT-success.svg)](LICENSE)

## Description

[Metrica](https://metrica.fun) is an analog of Google Analytics. The main purpose is to collect data from web pages, handle it and visualize.

[![Metrica](Metrica.svg)](https://metrica.fun)

## Installation. Unix

```bash
cp docker-compose.override.yml.general docker-compose.override.yml
cp .env.example .env

docker-compose run --rm frontend npm install

docker-compose up -d

cp backend/.env.example backend/.env
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan jwt:secret
docker-compose exec app php artisan migrate --seed

cp frontend/.env.example frontend/.env
```

Open browser:

`https://localhost:8443`

## Installation. Windows

First of all make sure you have installed `node:12.7`. 

```bash
cp docker-compose.override.yml.windows docker-compose.override.yml
cp .env.example .env
docker-compose up -d

docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan jwt:secret
docker-compose exec app php artisan migrate --seed

cp frontend/.env.example frontend/.env

cd frontend
npm install

npm run serve
```

Open browser:

`http://localhost:3000`

### Elasticsearch troubleshoot

The vm.max_map_count kernel setting needs to be set to at least 262144 for production use. Depending on your platform:

#### Linux

$ sysctl -w vm.max_map_count=262144

#### macOS with Docker for Mac

$ screen ~/Library/Containers/com.docker.docker/Data/vms/0/tty

sysctl -w vm.max_map_count=262144

#### Windows and macOS with Docker Toolbox

docker-machine ssh
sudo sysctl -w vm.max_map_count=262144

or

docker-machine ssh
tce-load -w -i nano.tcz
sudo sysctl -w vm.max_map_count=262144
cat /proc/sys/vm/max_map_count
sudo nano /mnt/sda1/var/lib/boot2docker/profile
sudo sysctl -w vm.max_map_count=262144 // put this line in the end of file
Ctrl+O // save it
exit
docker-machine restart default
