import {
    LOGIN,
    LOGOUT,
    SIGN_UP,
    RESET_PASSWORD,
    UPDATE_USER,
    FETCH_CURRENT_USER,
    SOCIAL_REDIRECT,
    SOCIAL_LOGIN,
} from './types/actions';
import {
    SET_AUTHENTICATED_USER,
    USER_LOGIN,
    USER_LOGOUT,
} from "./types/mutations";
import {updateUser} from '@/api/users';
import {
    authorize,
    getAuthUser,
    registerUser,
    resetPassword,
    getSocialRedirectUrl,
    socialLogin
} from '@/api/auth';
import {HAS_TOKEN} from "./types/getters";
import _ from 'lodash';

export default {
    [LOGIN]: (context, user) => {
        return authorize(user)
            .then(response => {
                context.commit(USER_LOGIN, response.data);
                return context.dispatch(FETCH_CURRENT_USER);
            }).catch((response) => {
                return Promise.reject(response.response.data.error.message);
            });


    },

    [LOGOUT]: (context) => {
        return new Promise(resolve => {
            context.commit(USER_LOGOUT);
            resolve();
        });
    },

    [UPDATE_USER]: (context, user) => {
        return updateUser(user)
            .then(response => {
                context.commit(SET_AUTHENTICATED_USER, response.data);
            });
    },

    [SIGN_UP]: (context, newUser) => {
        return registerUser(newUser)
            .then(response => {
                return response.data.email;
            })
            .catch((error) => {
                throw new Error(_.get(error, 'response.data.error.message', 'Unknown error'));
            });
    },

    [RESET_PASSWORD]: (context, payload) => {
        return resetPassword(payload).catch((error) => {
            switch (error.response.status) {
                case 404:
                    throw `It looks like there is no account associated with this email address.
                             You can  <a href="/signup"> create an account</a> to access our services.`;
                case 500:
                    throw 'Sorry, something wrong happened. Please, try again';
            }
        });
    },

    [FETCH_CURRENT_USER]: (context) => {
        if (!context.getters[HAS_TOKEN]) {
            return;
        }
        return getAuthUser().then(response => {
            context.commit(SET_AUTHENTICATED_USER, response.data);
        }).catch(() => {
            context.commit(USER_LOGOUT);
        });
    },

    [SOCIAL_LOGIN]: (context, data) => {
        return socialLogin(data)
            .then(response => {
                context.commit(USER_LOGIN, response.data);
                return context.dispatch(FETCH_CURRENT_USER);
            });
    },

    [SOCIAL_REDIRECT]: (context, provider) => {
        return getSocialRedirectUrl({provider})
            .then(response => response.data.url);
    },

};
