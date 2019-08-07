import axiosService from 'axios';

const axios = axiosService.create {
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Content-type': 'application/json',
        'Accept': 'application/json'
    }
};

const token = 'getTokenFromAuthService';

const authHeader = {
    'Authorization': 'Bearer ' + token
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
