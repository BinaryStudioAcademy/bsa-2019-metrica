import {
    SAVE_NEW_WEBSITE,
    SET_WEBSITE_DATA,
    UPDATE_WEBSITE,
    RESET_DATA,
    CHANGE_SELECTED_WEBSITE,
    FETCH_RELATE_WEBSITES,
    DEFAULT_SELECTED_WEBSITE,
} from './types/actions';
import {
    SET_CURRENT_WEBSITE,
    UPDATE_CURRENT_WEBSITE,
    SET_WEBSITE_INFO,
    RESET_CURRENT_WEBSITES,
    SET_FETCH_TRUE,
    RESET_WEBSITES_DATA,
    SET_SELECTED_WEBSITE,
    RESET_FETCH_WEBSITES,
    SET_RELATE_WEBSITES,
} from "./types/mutations";
import {addWebsite, updateWebsite, getRelateUserWebsites} from '@/api/website';

export default {

    [SET_WEBSITE_DATA]: (context, data) => {
        context.commit(SET_WEBSITE_INFO, data);
    },

    [FETCH_RELATE_WEBSITES]: (context) => {
        context.commit(SET_FETCH_TRUE);

        return getRelateUserWebsites().then(response => {
            context.commit(SET_RELATE_WEBSITES, response);
            context.dispatch(DEFAULT_SELECTED_WEBSITE);
        })
            .catch(() => {
            context.commit(RESET_CURRENT_WEBSITES);
        })
            .finally(() => {
            context.commit(RESET_FETCH_WEBSITES);
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
        context.commit(RESET_WEBSITES_DATA);
    },

    [CHANGE_SELECTED_WEBSITE]: (context, id) => {
        if (!id) {
            return;
        }
        if (context.state.selectedWebsite === id) {
            return;
        }

        context.commit(SET_SELECTED_WEBSITE, id);
    },

    [DEFAULT_SELECTED_WEBSITE]: (context) => {
        const website = context.state.relateUserWebsites.find(function(website) {
                return website.role === 'owner';
            }) || context.state.relateUserWebsites[0];

        const websiteId = website ? website.id : undefined;

        context.commit(SET_SELECTED_WEBSITE, websiteId);
        context.commit(SET_CURRENT_WEBSITE);
    },
};
