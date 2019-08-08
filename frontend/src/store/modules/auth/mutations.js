import {SET_AUTHENTICATED_USER, USER_LOGIN, USER_LOGOUT} from "./types/mutations";
import {USER_UPDATE} from './types/mutations';
import { EMPTY_USER } from '../../../services/Normalizer';

export default {
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