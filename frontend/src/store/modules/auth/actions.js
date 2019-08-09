import {LOGIN, LOGOUT, SIGNUP} from './types/actions';
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

            if(fakeUser.email === user.email && fakeUser.password === user.password) {
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
        return new Promise((resolve, reject) => {
            context.commit(USER_LOGOUT);
            resolve();
        });
    },

    [SIGNUP]: (context, newUser) => {
        return new Promise((resolve, reject) => {
            return requestService.create('auth/signup', {
                name: newUser.name,
                email: newUser.email,
                password: newUser.password
            })
                .then(function (res) {
                    resolve(res);
                })
                .catch(function (err) {
                    reject(err);
                });
        });
    },
}