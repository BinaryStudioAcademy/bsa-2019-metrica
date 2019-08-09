import {SET_TOKEN, USER_LOGIN, USER_LOGOUT} from "./modules/auth/types/mutations";
import storage from '../services/storage';

export const authPlugin = store => {

    let token = storage.hasToken() ? storage.getToken() : undefined;

    store.commit(`auth/${SET_TOKEN}`, token);

    store.subscribe((mutation, {}) => {
        switch (mutation.type) {
            case `auth/${USER_LOGIN}`: {
                storage.setToken(mutation.payload.access_token);
                break;
            }
            case `auth/${USER_LOGOUT}`: {
                storage.removeToken();
                break;
            }
        }
    });
};