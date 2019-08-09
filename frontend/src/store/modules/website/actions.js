import {GET_WEBSITE, SET_NAME_WEBSITE} from './types/actions';
import {SET_WEBSITE} from "./types/mutations";

export default {
    [GET_WEBSITE]: (context, userId) => {
        return new Promise((resolve, reject) => {
            const fakeWebsite = {
                name: 'slack',
                address: 'https://app.slack.com',
                userId: userId,
                trackingId: 123156123,
            };

            context.commit(SET_WEBSITE, fakeWebsite);
            resolve(fakeWebsite);
            reject({
                message: "Wrong website"
            });
        });
    },

    [SET_NAME_WEBSITE]: (context, {userId, name}) => {
        return new Promise((resolve, reject) => {
            const fakeWebsite = {
                name: name,
                userId: userId,
            };
            context.commit(SET_WEBSITE, fakeWebsite);
            resolve({name: name});
            reject({
                message: "Wrong website"
            });
        });
    },
}
