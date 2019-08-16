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
        return resetPassword(payload).then(() => {
                    return `Your reset password link was created. Check your email ${payload.email}, please.`;
            }).catch((err) => {
           throw new Error(err);
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