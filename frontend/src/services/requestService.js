import axios from 'axios';

axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'Content-type': 'application/json',
    'Accept': 'application/json'
}

const csrfToken = document.head.querySelector('meta[name="csrf-token"]');

if (csrfToken) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

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
