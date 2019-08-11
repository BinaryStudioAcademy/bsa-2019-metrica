import {SAVE_NEW_WEBSITE, SET_WEBSITE_DATA} from './types/actions';
import {ADD_WEBSITE, SET_WEBSITE_INFO} from "./types/mutations";
import requestService from "@/services/requestService";
import config from "@/config";

const resourceUrl = config.getApiUrl() + '/websites';

export default {
    [SET_WEBSITE_DATA]: (context, data) => {
        context.commit(SET_WEBSITE_INFO, data);
    },
    [SAVE_NEW_WEBSITE]: (context) => {
        const newDataSite = context.state.newWebsite;

        return requestService.create(resourceUrl, newDataSite)
                .then( response => context.commit(ADD_WEBSITE, response.data.data))
                .catch(response => { return { errors: response.error } });
    }
}