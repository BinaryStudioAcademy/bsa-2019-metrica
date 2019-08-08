import {LOGIN, LOGOUT} from './types/actions';
import {SET_AUTHENTICATED_USER, USER_LOGIN, USER_LOGOUT} from "./types/mutations";
import requestService from "../../../services/requestService";

export default {
    [LOGIN]: async (context, user) => {
        const url = process.env.VUE_APP_API_URL + '/auth/login';

        try {
            const response = await requestService.create(url, user);

            context.commit(USER_LOGIN, response);
            context.commit(SET_AUTHENTICATED_USER, user);

            return Promise.resolve();
        } catch (error) {
            console.log(error);
            return Promise.reject(error);
        }

/*        return new Promise((resolve, reject) => {
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
        });*/
    },

    [LOGOUT]: (context) => {
        return new Promise((resolve, reject) => {
            context.commit(USER_LOGOUT);
            resolve();
        });
    },
}