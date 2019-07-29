FROM node:12.7-alpine

ENV NPM_CONFIG_LOGLEVEL warn

RUN mkdir -p /app
WORKDIR /app

COPY ./frontend/package*.json /app/
RUN npm install http-server -g \
    && npm install

EXPOSE 3000