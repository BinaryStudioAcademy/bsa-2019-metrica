import axios from 'axios';

const baseURL = process.env.VUE_APP_URL || '/';
const axiosInstance = axios.create({ baseURL });

axiosInstance.interceptors.request.use((config) => {

    config.headers['X-Requested-With'] = 'XMLHttpRequest';
    config.headers['Content-type'] = 'application/json';
    config.headers['Accept'] = 'application/json';

    const token = getToken();

    if (token) {
        config.headers.Authorization = token;
    }

    return config;
});

const getToken = () => {
    return 'Bearer ' + 'tokenFromSessionStore';
};

const get = (url, headers = {}, params = {}) => {
    return axiosInstance.get(url, {
        params: params,
        headers: headers
    });
};

const create = (url, data, headers = {}) => {
    return axiosInstance.post(url, data, {
        headers: headers
    });
};

const update = (url, data, headers = {}) => {
    return axiosInstance.put(url, data, {
        headers: headers
    });
};

const destroy = url => axiosInstance.delete(url);

const requestService = {
    create,
    get,
    update,
    destroy
};

export default requestService;
