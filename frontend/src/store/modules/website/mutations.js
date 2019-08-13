import {UPDATE_CURRENT_WEBSITE, SET_CURRENT_WEBSITE, SET_WEBSITE_INFO, RESET_CURRENT_WEBSITE} from "./types/mutations";

export default {
    [SET_WEBSITE_INFO]: (state, data) => {
        state.newWebsite = {
            ...state.newWebsite,
            ...data,
        };
    },
    [SET_CURRENT_WEBSITE]: (state, website) => {
        state.isCurrentWebsite = true;
        state.currentWebsite = website;
    },
    [UPDATE_CURRENT_WEBSITE]: (state, website) => {
        state.currentWebsite = {
            ...state.currentWebsite,
            ...website
        };
    },
    [RESET_CURRENT_WEBSITE]: (state) => {
        state.currentWebsite = {
            name: '',
            domain: '',
            single_page: false,
            tracking_number: ''
        };
        state.isCurrentWebsite = false;
    }
}