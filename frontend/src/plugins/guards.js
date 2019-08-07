export default {
    auth: store => (to, from, next) => {
        if (!store.getters['auth/isLoggedIn']) {
            next({
                path: '/login'
            });
        }
    },
    guest: store => (to, from, next) => {
        if (store.getters['auth/isLoggedIn']) {
            next({
                path: '/'
            });
        } else {
            next();
        }
    }
};