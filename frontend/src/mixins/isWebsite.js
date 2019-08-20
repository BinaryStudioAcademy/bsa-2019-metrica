import store from "../store";

export const isWebsite = {
    beforeRouteEnter: (to, from, next) => {
        if (!store.state.website.isCurrentWebsite) {
            next({
                name: 'add_website'
            });
        } else {
            next();
        }
    }
};
