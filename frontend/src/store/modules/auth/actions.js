import {LOGIN, LOGOUT, GET_USER_DATA, SET_IS_LOGGED_IN} from './types/actions';
import {SET_AUTHENTICATED_USER, USER_LOGIN, USER_LOGOUT, SET_USER_IS_LOGGED_IN} from "./types/mutations";


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