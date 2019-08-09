import {GET_WEBSITE, SET_NAME_WEBSITE} from './types/actions';
import {SET_WEBSITE} from "./types/mutations";

export default {
    [GET_WEBSITE]: (context, user_id) => {
        return new Promise((resolve, reject) => {
            const fakeWebsite = {
                name: 'slack',
                adress: 'https://app.slack.com',
                user_id: user_id,
                tracking_id: 123156123,
            };
            const websiteMapper = website => ({
                id: website.id,
                name: website.name,
                adress: website.address,
                user_id: website.user_id,
                tracking_id: website.tracking_id,
            });

            context.commit(SET_WEBSITE, fakeWebsite);
            resolve(    fakeWebsite.map(websiteMapper));
            reject({
                message: "Wrong website"
            });
        });
    },

    [SET_NAME_WEBSITE]: (context, user_id, name) => {
        return new Promise(resolve => {
            const website = {
                name: name,
                user_id: user_id,
            };
            context.commit(SET_WEBSITE, website);
            resolve(website);
        });
    },
}
