import {LOGIN, LOGOUT, SIGNUP, RESET_PASSWORD} from './types/actions';
import {SET_AUTHENTICATED_USER, USER_LOGIN, USER_LOGOUT} from "./types/mutations";
import requestService from "@/services/requestService";

export default {
    [LOGIN]: (context, user) => {
        return new Promise((resolve, reject) => {
            const fakeUser = {
                email: 'test@gmail.com',
                name: 'test user',
                password: 'secretpassword',
                access_token: 'jwt-auth-token',
                id: 1
            };

            if (fakeUser.email === user.email && fakeUser.password === user.password) {
                context.commit(USER_LOGIN, fakeUser);
                context.commit(SET_AUTHENTICATED_USER, fakeUser);
                resolve(fakeUser);
            }

            reject({
                message: "Wrong email or password"
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