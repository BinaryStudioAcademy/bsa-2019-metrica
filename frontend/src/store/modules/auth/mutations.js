import {SET_AUTHENTICATED_USER, SET_TOKEN, USER_LOGIN, USER_LOGOUT} from "./types/mutations";

export default {
    [SET_TOKEN]: (state, token) => {
        state.token = token;
    },
    [USER_LOGIN]: (state, response) => {
        state.token = response.access_token;
        state.isLoggedIn = true;
    },
    [USER_LOGOUT]: (state) => {
        state.token = undefined;
        state.currentUser = undefined;
        state.isLoggedIn = false;
    },
    [SET_AUTHENTICATED_USER]: (state, user) => {
        state.isLoggedIn = true;
        state.currentUser = user;
    },

};