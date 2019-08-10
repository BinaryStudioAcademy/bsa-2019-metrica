import {SET_AUTHENTICATED_USER, SET_TOKEN, USER_LOGIN, USER_LOGOUT, SET_USER_IS_LOGGED_IN, SET_AUTHENTICATED} from "./types/mutations";

export default {
    [SET_TOKEN]: (state, token) => {
        state.token = token;
    },
    [USER_LOGIN]: (state, response) => {
        state.token = response.token;
    },
    [USER_LOGOUT]: (state) => {
        state.token = undefined;
        state.currentUser = {
            name: '',
            email: '',
            id: null
        };
        state.isLoggedIn = false;
    },
    [SET_AUTHENTICATED_USER]: (state, user) => {
        state.isLoggedIn = true;
        state.currentUser = user;
    },
    [SET_USER_IS_LOGGED_IN]: (state,data) => {
        state.isLoggedIn = data;
    },
    [SET_AUTHENTICATED]: (state, user) => {
        state.isLoggedIn = true;
        state.currentUser = user;
    },
};