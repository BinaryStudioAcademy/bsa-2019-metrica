import Echo from 'laravel-echo';
import Storage from '@/services/storage';
import config from "@/config";

const configPusher = {
    broadcaster: 'pusher',
    key: config.getPusherApiKey(),
    authEndpoint: config.getPusherAppAuthEndpoint(),
    cluster: config.getPusherCluster(),
    encrypted: true,
    auth: {
        headers: {
            Authorization: 'Bearer ' + Storage.getToken()
        },
    },
};

export const pusher = new Echo(configPusher);
export const getSocketId = () => pusher.socketId();
