import axios from 'axios';

axios.interceptors.request.use(function (config) {

    config.headers.['X-Requested-With'] = 'XMLHttpRequest';
    config.headers.['Content-type'] = 'application/json';
    config.headers.['Accept'] = 'application/json';

    let token = getToken();
    if (token) {
        config.headers.['Authorization'] = token;
    }
    return config;
});

const getToken = () => {
    return 'Bearer ' + 'tokenFromSessionStore';
};

const get = (url, params = {}, headers = {}) => {
    axios.get(url, {
        params: params,
        headers: {
            ...headers,
            ...authHeader,
        }
    });
};

const create = (url, data, headers = {}) => {
    axios.post(url, data, {
        headers: {
            ...headers,
            ...authHeader
        }
    });
};

const update = (url, data, headers = {}) => {
    axios.put(url, {
        data: data,
        headers: {
            ...headers,
            ...authHeader
        }
    });
};

const destroy = (url, params = {}) => {
    axios.delete(url, {
        headers: {
            ...authHeader
        },
        params: params
    });
};

const requestService = {
    create,
    get,
    update,
    destroy
};

export default requestService;
