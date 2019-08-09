import {ADD_NEW_WEBSITE} from './types/actions';
import {ADD_WEBSITE} from "./types/mutations";

export default {
    [ADD_NEW_WEBSITE]: (context, website) => {
        return new Promise((resolve, reject) => {
            const fakeWebsiteData = {
                name: 'Website name',
                domain: 'http://domain.com',
                single_page: website.single_page,
                tracking_info_id: '123456789-10',
            };

            if (fakeWebsiteData.tracking_info_id && fakeWebsiteData.name === website.name && fakeWebsiteData.domain === website.domain) {
                context.commit(ADD_WEBSITE, fakeWebsiteData);
                resolve(fakeWebsiteData);
            } else if (fakeWebsiteData.name !== website.name) {
                reject({
                    errors: {
                        name: "Wrong name of website"
                    }
                });
            } else if (fakeWebsiteData.domain !== website.domain) {
                reject({
                    errors: {
                        domain: "Wrong domain of website"
                    }
                });
            }

        });
    }
}