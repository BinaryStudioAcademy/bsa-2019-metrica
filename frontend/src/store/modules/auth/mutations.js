import {SET_AUTHENTICATED_USER, USER_LOGIN, USER_LOGOUT} from "./types/mutations";
import storage from "../../../services/storage";

export default {
    [USER_LOGIN]: (state, response) => {
        storage.setToken(response.token);
        state.token = response.token;
        state.isLoggedIn = true;
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
    }
};