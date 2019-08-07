export default {
    USER_LOGIN: (state, response) => {
        state.token = response.access_token;
        state.isLoggedIn = true;
    },
    USER_LOGOUT: (state) => {
        state.token = '';
        state.currentUser = {
            name: '',
            email: '',
            id: null
        };
        state.isLoggedIn = false;
    },
    SET_AUTHENTICATED_USER: (state, user) => {
        state.isLoggedIn = true;
        state.currentUser = user;
    }
};