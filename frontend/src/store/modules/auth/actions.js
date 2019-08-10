import {LOGIN, LOGOUT, SIGNUP, RESET_PASSWORD} from './types/actions';
import {SET_AUTHENTICATED_USER, USER_LOGIN, USER_LOGOUT} from "./types/mutations";
import requestService from "@/services/requestService";
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

    [SIGNUP]: (context, newUser) => {
        return requestService.create('/auth/register', {
                name: newUser.name,
                email: newUser.email,
                password: newUser.password
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
    }
}