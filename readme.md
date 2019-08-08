# BSA 2019 | PHP | Metrica

## Description

Metrica is an analog of Google Analytics. The main purpose is to collect data from web pages, handle it and visualize.

## Installation. Unix

```bash
cp docker-compose.override.yml.general docker-compose.override.yml
cp .env.example .env
docker-compose up -d

cp backend/.env.example backend/.env
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate --seed

cp frontend/.env.example frontend/.env

docker-compose exec frontend npm install
docker-compose exec frontend npm run serve

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
docker-compose exec app php artisan migrate --seed

cp frontend/.env.example frontend/.env

cd frontend
npm install

npm run serve
```

Open browser:

`http://localhost:3000`


### Elasticsearch troubleshoot:

The vm.max_map_count kernel setting needs to be set to at least 262144 for production use. Depending on your platform:

#### Linux

$ sysctl -w vm.max_map_count=262144

#### macOS with Docker for Mac

$ screen ~/Library/Containers/com.docker.docker/Data/vms/0/tty

sysctl -w vm.max_map_count=262144

#### Windows and macOS with Docker Toolbox

docker-machine ssh
sudo sysctl -w vm.max_map_count=262144