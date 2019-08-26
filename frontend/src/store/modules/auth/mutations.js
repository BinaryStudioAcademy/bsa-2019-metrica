import {
    SET_AUTHENTICATED_USER,
    SET_TOKEN,
    USER_LOGIN,
    USER_LOGOUT,
} from "./types/mutations";
import { updateSocketAuthToken, removeSocketAuthToken } from '@/services/echoService';

export default {
    [SET_TOKEN]: (state, token) => {
        state.token = token;
    },
    [USER_LOGIN]: (state, response) => {
        state.token = response.token;
        updateSocketAuthToken(response.token);
    },
    [USER_LOGOUT]: (state) => {
        state.token = undefined;
        state.currentUser = undefined;
        state.isLoggedIn = false;
        removeSocketAuthToken();
    },
    [SET_AUTHENTICATED_USER]: (state, user) => {
        state.isLoggedIn = true;
        state.currentUser = user;
    },
};
