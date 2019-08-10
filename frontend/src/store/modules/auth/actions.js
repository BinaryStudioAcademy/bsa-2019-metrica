import {LOGIN, LOGOUT, SIGNUP,RESET_PASSWORD,GET_USER_DATA, SET_IS_LOGGED_IN} from './types/actions';
import {SET_AUTHENTICATED_USER, USER_LOGIN, USER_LOGOUT,SET_USER_IS_LOGGED_IN,SET_AUTHENTICATED} from "./types/mutations";
import { authorize, getAuthUser, registerUser } from '@/api/auth';

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

    [SIGNUP]: (context, newUser) => {
        return registerUser(newUser);
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


    [GET_USER_DATA]: (context) => {
        getAuthUser().then(response => {
            const user = response.data;
            alert(user.name);
            context.commit(SET_AUTHENTICATED,user);

        })
            .catch((err) => alert(err.message));
    },

    [SET_IS_LOGGED_IN]: (context, data) => {
        context.commit(SET_USER_IS_LOGGED_IN, data);
    }
}