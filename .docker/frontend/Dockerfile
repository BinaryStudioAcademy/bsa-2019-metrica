FROM node:12.7-alpine

ENV NPM_CONFIG_LOGLEVEL warn

COPY frontend/package*.json ./
RUN npm install http-server -g \
    && npm install

EXPOSE 3000