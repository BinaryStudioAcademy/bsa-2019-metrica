import {USER_UPDATE} from './types/mutations';
import { EMPTY_USER } from '../../../services/Normalizer';
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
        state.currentUser = EMPTY_USER();
        state.isLoggedIn = false;
    },
    [SET_AUTHENTICATED_USER]: (state, user) => {
        state.isLoggedIn = true;
        state.currentUser = user;
    },
    [USER_UPDATE]: (state, response) => {
        state.user = {
            name: response.name,
            email: response.email,
            password: response.password,
        }
    }
};