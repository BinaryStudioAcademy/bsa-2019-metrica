import {GET_AUTHENTICATED_USER, GET_TOKEN, HAS_TOKEN, IS_LOGGED_IN, GET_USER} from "./types/getters";

export default {
    [HAS_TOKEN]: (state) => !!state.token,
    [IS_LOGGED_IN]: (state) => state.isLoggedIn,
    [GET_AUTHENTICATED_USER]: (state) => state.isLoggedIn ? state.currentUser : undefined,
    [GET_TOKEN]: (state) => state.token,

    [GET_USER]: (state) => state.currentUser,
};