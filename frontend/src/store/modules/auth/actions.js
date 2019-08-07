export default {
    login: (context, user) => {
        return new Promise((resolve, reject) => {
            const fakeUser = {
                email: 'test@gmail.com',
                name: 'test user',
                access_token: 'jwt-auth-token',
                id: 1
            };

            context.commit('USER_LOGIN', fakeUser);
            context.commit('SET_AUTHENTICATED_USER', fakeUser);

            resolve(fakeUser);
        });
    }
}