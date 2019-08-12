import {UPDATE_CURRENT_WEBSITE, SET_WEBSITE_INFO} from "./types/mutations";

export default {
    [SET_WEBSITE_INFO]: (state, data) => {
        state.newWebsite = {
            ...state.newWebsite,
            ...data,
        };
    },
    [UPDATE_CURRENT_WEBSITE]: (state, website) => {
        state.currentWebsite = {
            ...state.currentWebsite,
            ...website
        };
    },
}
