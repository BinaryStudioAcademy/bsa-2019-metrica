import Echo from 'laravel-echo';
import Storage from '@/services/storage';
import config from "@/config";
import Pusher from 'pusher-js';

const configPusher = {
    broadcaster: 'pusher',
    key: config.getPusherApiKey(),
    client: Pusher,
    authEndpoint: config.getPusherAppAuthEndpoint(),
    cluster: config.getPusherCluster(),
    encrypted: true,
    auth: {
        headers: {},
    },
};

if (Storage.hasToken()) {
    config.auth.headers = {
        Authorization: `${Storage.getTokenType()} ${Storage.getToken()}`
    };
}

export const pusher = new Echo(configPusher);

export const updateSocketAuthToken = (token) => {
    pusher.config.auth.headers.Authorization = `${Storage.getTokenType()} ${token}`;
};

export const removeSocketAuthToken = () => {
    pusher.config.auth.headers = {};
};

export const getSocketId = () => pusher.socketId();
