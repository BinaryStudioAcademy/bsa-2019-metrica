import {SAVE_NEW_WEBSITE, SET_WEBSITE_DATA, UPDATE_WEBSITE} from './types/actions';
import {UPDATE_CURRENT_WEBSITE, SET_WEBSITE_INFO} from "./types/mutations";

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
                context.commit(UPDATE_CURRENT_WEBSITE, fakeWebsiteData);
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
}
