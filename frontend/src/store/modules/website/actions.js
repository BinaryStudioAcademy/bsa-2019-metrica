import {SAVE_NEW_WEBSITE, SET_NAME, SET_DOMAIN, SET_SPA} from './types/actions';
import {ADD_WEBSITE, SET_SITE_NAME, SET_SITE_DOMAIN, SET_SITE_SPA} from "./types/mutations";

export default {
    [SET_NAME]: (context, name) => {
        context.commit(SET_SITE_NAME, name);
    },
    [SET_DOMAIN]: (context, domain) => {
        context.commit(SET_SITE_DOMAIN, domain);
    },
    [SET_SPA]: (context, single_page) => {
        context.commit(SET_SITE_SPA, single_page);
    },
    [SAVE_NEW_WEBSITE]: (context) => {
        const newDataSite = context.state.newWebsite;

        return new Promise((resolve, reject) => {
            if(!newDataSite.name || !newDataSite.domain) {
                reject({
                    errors: {
                        message: "Fill in all thi fields correctly."
                    }
                });
            }
            const fakeWebsiteData = {
                name: 'Website name',
                domain: 'http://domain.com',
                single_page: newDataSite.single_page,
                tracking_info_id: '123456789-10',
            };

            if (fakeWebsiteData.tracking_info_id && fakeWebsiteData.name === newDataSite.name && fakeWebsiteData.domain === newDataSite.domain) {
                context.commit(ADD_WEBSITE, fakeWebsiteData);
                resolve(fakeWebsiteData);
            } else if (fakeWebsiteData.name !== newDataSite.name) {
                reject({
                    errors: {
                        name: "Wrong name of website"
                    }
                });
            } else if (fakeWebsiteData.domain !== newDataSite.domain) {
                reject({
                    errors: {
                        domain: "Wrong domain of website"
                    }
                });
            }

        });
    }
}