# BSA 2019 | PHP | Metrica

## Description

Metrica is an analog of Google Analytics. The main purpose is to collect data from web pages, handle it and visualize.

## Installation

```bash
cp .env.example .env
docker-compose up -d

docker-compose exec app composer install
```

Open browser:

`https://localhost:8443`

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