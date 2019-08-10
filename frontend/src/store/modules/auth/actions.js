import {LOGIN, LOGOUT, RESET_PASSWORD,GET_USER_DATA, SET_IS_LOGGED_IN} from './types/actions';
import {SET_AUTHENTICATED_USER, USER_LOGIN, USER_LOGOUT,SET_USER_IS_LOGGED_IN} from "./types/mutations";
import { authorize, getAuthUser } from '@/api/auth';

export default {
    [LOGIN]: (context, user) => {
        return authorize(user)
          .then(response => {
            context.commit(USER_LOGIN, response.data);

            return getAuthUser()
              .then(response => {
                const user = response.data[0];
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

    [RESET_PASSWORD]: () => {
        return new Promise((resolve, reject) => {
            const fakeResponse = 201;
            switch (fakeResponse) {
                case 201:
                    resolve("Your reset password link was created. Check your email, please.");
                    break;
                case 500:
                    reject("Sorry, something wrong happened. Please, try again.");
                    break;
                default:
                    reject("User with this email does not exist. Please, check if the password is correct.");
            }
        })
    },

    [GET_USER_DATA]: () => {
        // alert('hello!');
        //  getAuthUser().then(response => {
        //     const user = response.data[0];
        //     alert(user)
        // })
        //     .catch(() => alert('error!'));
    },

    [SET_IS_LOGGED_IN]: (context, data) => {
        context.commit(SET_USER_IS_LOGGED_IN, data);
    }
}