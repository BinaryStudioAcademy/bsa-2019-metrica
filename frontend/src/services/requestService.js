import axios from 'axios';

axios.interceptors.request.use(function (config) {

    config.headers['X-Requested-With'] = 'XMLHttpRequest';
    config.headers['Content-type'] = 'application/json';
    config.headers['Accept'] = 'application/json';

    let token = getToken();
    if (token) {
        config.headers.Authorization = token;
    }
    return config;
});

const getToken = () => {
    return 'Bearer ' + 'tokenFromSessionStore';
};

const get = (url, headers = {}, params = {}) => {
    return axios.get(url, {
        params: params,
        headers: headers
    });
};

const create = (url, data, headers = {}) => {
    return axios.post(url, data, {
        headers: headers
    });
};

const update = (url, data, headers = {}) => {
    return axios.put(url, data, {
        headers: headers
    });
};

const destroy = url => axios.delete(url);


const requestService = {
    create,
    get,
    update,
    destroy
};

export default requestService;
