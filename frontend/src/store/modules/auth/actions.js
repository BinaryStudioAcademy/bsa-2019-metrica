export default {
    login: (context, user) => {
        return new Promise((resolve, reject) => {
            authService.login(user).then(function (res) {
                const userData = res.data.data;
                context.commit('USER_LOGIN', userData);
                //context.dispatch('fetchAuthenticatedUser');
                resolve(res);
            }).catch(function (err) {
                reject(err);
            })
        });
    }
}