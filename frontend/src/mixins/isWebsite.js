import store from "../store";

export const isWebsite = {
    beforeRouteEnter: (to, from, next) => {
        if (!store.state.website.relateUserWebsites.length) {
            next({
                name: 'add_website'
            });
        } else {
            next();
        }
    }
};
