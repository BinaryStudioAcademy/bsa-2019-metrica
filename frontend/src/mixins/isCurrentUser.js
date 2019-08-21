import store from "../store";

export const isCurrentUser = {
    beforeRouteEnter: (to, from, next) => {
        if (store.state.auth.currentUser) {
            next({
                name: 'dashboard'
            });
        } else {
            next();
        }
    }
};


