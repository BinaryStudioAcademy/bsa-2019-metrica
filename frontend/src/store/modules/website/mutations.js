import {ADD_WEBSITE, SET_WEBSITE_INFO} from "./types/mutations";

export default {
    [SET_WEBSITE_INFO]: (state, data) => {
        state.newWebsite = {
            ...state.newWebsite,
            ...data,
        };
    },
    [ADD_WEBSITE]: (state, website) => {
        state.currentWebsite = website;
    },
}