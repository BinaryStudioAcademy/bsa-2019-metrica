
const token = 'qwerty'; // get from authService

const authHeader = {
	'Authorization': 'Bearer ' + token
};

const get = (url, params = {}, headers = {}) => {
	axios.get(url, {
		params: {
			...params
		},
		headers: { 
	        'Content-type': 'application/json',		
			...headers,
			authHeader,
		}
	});
}

const post = (url, data, headers = {}) => {
	axios.post(url, data, {
	    headers: {
	        'Content-type': 'application/json',
	        ...headers,
	        ...authHeader
	    }
	});
}

const requestService = {
    post,
    get
};

export default requestService;