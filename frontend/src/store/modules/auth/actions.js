import {LOGIN, LOGOUT, SIGNUP, RESET_PASSWORD, UPDATE_USER, FETCH_CURRENT_USER} from './types/actions';
import {
    SET_AUTHENTICATED_USER,
    USER_LOGIN,
    USER_LOGOUT,
} from "./types/mutations";
import {updateUser} from '@/api/users';
import {authorize, getAuthUser, registerUser, resetPassword} from '@/api/auth';
import {HAS_TOKEN} from "./types/getters";


export default {
    [LOGIN]: (context, user) => {
        return authorize(user)
            .then(response => {
                context.commit(USER_LOGIN, response.data);

                return getAuthUser()
                    .then(response => {
                        const user = response.data;
                        context.commit(SET_AUTHENTICATED_USER, user);

                        return user;
                    });
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

    [SIGNUP]: (context, newUser) => {
        return registerUser(newUser);
    },

    [RESET_PASSWORD]: (context, payload) => {
        return resetPassword(payload).then((response) => {
            if (response.data) {
                return `Your reset password link was created. Check your email ${payload.email}, please.`;
            } else if (response.error.status === 404) {
                throw `It looks like there is no account associated with this email address.
                 You can  <a href="/signup"> create an account</a> to access our services.`;
            } else if (response.error.status === 500) {
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

};
