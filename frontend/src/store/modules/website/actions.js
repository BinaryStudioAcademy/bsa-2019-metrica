import {SAVE_NEW_WEBSITE, SET_WEBSITE_DATA, UPDATE_WEBSITE} from './types/actions';
import {ADD_WEBSITE, SET_WEBSITE_INFO, UPDATE_CURRENT_WEBSITE} from "./types/mutations";
import { addWebsite } from '@/api/website';

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
            resolve();
            return addWebsite(newDataSite)
                    .then( response => context.commit(ADD_WEBSITE, response.data.data))
                    .catch(response => { return { errors: response.error } });
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
