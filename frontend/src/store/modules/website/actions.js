import {
    SAVE_NEW_WEBSITE,
    SET_WEBSITE_DATA,
    FETCH_CURRENT_WEBSITE,
    UPDATE_WEBSITE,
    RESET_DATA,
    CHANGE_SELECTED_WEBSITE,
    FETCH_RELATE_WEBSITES,
} from './types/actions';
import {
    SET_CURRENT_WEBSITE,
    UPDATE_CURRENT_WEBSITE,
    SET_WEBSITE_INFO,
    RESET_CURRENT_WEBSITE,
    SET_FETCH_TRUE,
    RESET_WEBSITE_DATA,
    SET_SELECTED_WEBSITE,
    SET_IS_FETCH_WEBSITES,
    RESET_FETCH_WEBSITES,
    SET_RELATE_WEBSITES,
    SET_DEFAULT_SELECTED_WEBSITE
} from "./types/mutations";
import {addWebsite, updateWebsite, getCurrentUserWebsite, getRelateUserWebsites} from '@/api/website';

export default {

    [SET_WEBSITE_DATA]: (context, data) => {
        context.commit(SET_WEBSITE_INFO, data);
    },

    [FETCH_CURRENT_WEBSITE]: (context) => {
        context.commit(SET_FETCH_TRUE);
        const id = context.state.currentWebsite.id;

        return getCurrentUserWebsite(id).then(response => {
            context.commit(SET_CURRENT_WEBSITE, response.data);
            if(id === 0) {
                context.commit(SET_DEFAULT_SELECTED_WEBSITE, response.data);
            }
        })
            .catch(() => {
            context.commit(RESET_CURRENT_WEBSITE);
        });
    },

    [SAVE_NEW_WEBSITE]: (context) => {
        const newDataSite = context.state.newWebsite;

        if (!newDataSite.name && newDataSite.domain) {
            throw {
                errors: {
                    name: "Name can not be empty."
                }
            };
        }

        if (!newDataSite.domain && newDataSite.name) {
            throw {
                errors: {
                    domain: "Domain can not be empty."
                }
            };
        }

        if (!newDataSite.name && !newDataSite.domain) {
            throw {
                errors: {
                    message: "Name and Domain can not be empty"
                }
            };
        }

        return addWebsite(newDataSite)
            .then( response => context.commit(SET_CURRENT_WEBSITE, response.data))
            .catch( error => {
                const errorBag = error.response.data.errors;

                if (!errorBag) {
                    throw {
                        errors: {
                            message: "Unknown error"
                        },
                    };
                }

                if (errorBag.name) {
                    throw {
                        errors: {
                            name: errorBag.name
                        }
                    };
                }

                if (errorBag.domain) {
                    throw {
                        errors: {
                            domain: errorBag.domain
                        }
                    };
                }

                if (errorBag) {
                    throw {
                        errors: {
                            message: errorBag
                        }
                    };
                }
            });
    },

    [UPDATE_WEBSITE]: (context, update) => {

        if (!update.name) {
            throw { message: "Name can not be empty." };
        }

        let id = context.state.currentWebsite.id;
        if (!id) {
            throw { message: "Current website is undefined." };
        }

        return updateWebsite(update, id)
                .then((response) => {
                    context.commit(UPDATE_CURRENT_WEBSITE, response.data);
                })
                .catch(error => {
                    throw { message: error.response.data.errors.name };
                });
    },
    [RESET_DATA]: (context) => {
        context.commit(RESET_WEBSITE_DATA);
    },

    [CHANGE_SELECTED_WEBSITE]: (context, payload) => {
        if (context.state.relateUserWebsites.selectedWebsite.value === payload.value) {
            return;
        }

        context.commit(SET_SELECTED_WEBSITE, payload);
        context.dispatch(FETCH_CURRENT_WEBSITE)
            .catch(error => {
                throw error.message;
            });
    },

    [FETCH_RELATE_WEBSITES]: (context) => {
        context.commit(SET_IS_FETCH_WEBSITES);
        return getRelateUserWebsites().then(response => {
            context.commit(SET_RELATE_WEBSITES, response);
        }).finally(() => {
            context.commit(RESET_FETCH_WEBSITES);
        });
    },
};
