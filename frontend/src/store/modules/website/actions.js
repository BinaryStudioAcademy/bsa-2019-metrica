import {SAVE_NEW_WEBSITE, SET_WEBSITE_DATA, FETCH_CURRENT_WEBSITE, UPDATE_WEBSITE} from './types/actions';
import {SET_CURRENT_WEBSITE, UPDATE_CURRENT_WEBSITE, SET_WEBSITE_INFO, RESET_CURRENT_WEBSITE} from "./types/mutations";
import {addWebsite, getCurrentUserWebsite} from '@/api/website';

export default {
    [SET_WEBSITE_DATA]: (context, data) => {
        context.commit(SET_WEBSITE_INFO, data);
    },
    [FETCH_CURRENT_WEBSITE]: (context) => {
        return getCurrentUserWebsite().then(response => {
            context.commit(SET_CURRENT_WEBSITE, response.data);
        }).catch(() => {
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

        if(!newDataSite.name && !newDataSite.domain) {
            throw {
                errors: {
                    message: "Name and Domain can not be empty"
                }
            };
        }

        return addWebsite(newDataSite)
                    .then( response => context.commit(SET_CURRENT_WEBSITE, response.data))
                    .catch( error => {

                        let errorBag = error.response.data.errors;

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

                        if (errorBag && !errorBag.name && !errorBag.domain) {
                            throw {
                                errors: {
                                    message: errorBag
                                }
                            };
                        }
                    });
    },
    [UPDATE_WEBSITE]: (context, name) => {
        return new Promise((resolve, reject) => {
            const website = {
                name: name,
            };
            const fakeResponse = 200;
            switch (fakeResponse) {
                case 200:
                    context.commit(UPDATE_CURRENT_WEBSITE, website);
                    resolve({ message:'Name Success Save'});
                    break;
                default:
                    reject({ message:"Sorry, something wrong happened. Please, try again."});
                    break;
            }
        });
    },
};