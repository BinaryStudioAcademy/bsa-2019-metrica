export default {
    login: (context, user) => {
        return new Promise((resolve, reject) => {
            const fakeUser = {
                email: 'test@gmail.com',
                name: 'test user',
                password: 'secretpassword',
                access_token: 'jwt-auth-token',
                id: 1
            };

            if(fakeUser.email === user.email && fakeUser.password === user.password) {
                context.commit('USER_LOGIN', fakeUser);
                context.commit('SET_AUTHENTICATED_USER', fakeUser);
                resolve(fakeUser);
            }

            reject({
                message: "Wrong email or password"
            });
        });
    },

    logout: (context) => {
        return new Promise((resolve, reject) => {
            context.commit('USER_LOGOUT');
            resolve();
        });
    },
}