import {SAVE_NEW_WEBSITE, SET_WEBSITE_DATA, SET_NAME_WEBSITE} from './types/actions';
import {ADD_WEBSITE, SET_WEBSITE_INFO} from "./types/mutations";

export default {
    [SET_WEBSITE_DATA]: (context, data) => {
        context.commit(SET_WEBSITE_INFO, data);
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
                tracking_number: '123456789-10',
            };

            if (fakeWebsiteData.tracking_number && fakeWebsiteData.name === newDataSite.name && fakeWebsiteData.domain === newDataSite.domain) {
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
    },
    [SET_NAME_WEBSITE]: (context, user_id, name) => {
        try {
            const website = {
                name: name,
                user_id: user_id,
            };
            context.commit(SET_WEBSITE_INFO, website);

            return Promise.resolve();
        } catch (error) {

            return Promise.reject(error);
        }
    },
}
