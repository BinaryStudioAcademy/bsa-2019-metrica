import Echo from 'laravel-echo';
import Storage from '@/services/storage';
import config from "@/config";
import Pusher from 'pusher-js';

const tokenTypeName = 'Bearer';

const configPusher = {
    authEndpoint: config.getPusherAppAuthEndpoint(),
    cluster: config.getPusherCluster(),
    forceTLS: true,
    auth: {
        headers: {},
    },
};

if (Storage.hasToken()) {
    configPusher.auth.headers = {
        Authorization: `${tokenTypeName} ${Storage.getToken()}`
    };
}

const pusher = new Pusher(config.getPusherApiKey(), configPusher);

export const echoInstance = new Echo({
    broadcaster: 'pusher',
    key: config.getPusherApiKey(),
    encrypted: true,
    client: pusher
});

export const updateSocketAuthToken = (token) => {
    echoInstance.options.client.config.auth.headers.Authorization = `${tokenTypeName} ${token}`;
};

export const removeSocketAuthToken = () => {
    echoInstance.options.client.config.auth.headers = {};
};

export const getSocketId = () => echoInstance.socketId();
