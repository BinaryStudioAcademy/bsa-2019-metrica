FROM node:12.7-alpine

ENV NPM_CONFIG_LOGLEVEL warn

RUN npm install http-server -g \
	&& mkdir -p /app
WORKDIR /app

COPY ./frontend/dist /app

EXPOSE 3000

CMD ["hs", "-p", "3000"]
