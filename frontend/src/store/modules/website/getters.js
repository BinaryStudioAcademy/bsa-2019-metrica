import {
    GET_NEW_WEBSITE,
    IS_CURRENT_WEBSITE,
    GET_SELECTED_WEBSITE,
    GET_RELATE_WEBSITES,
    GET_WEBSITE_DATA,
} from "./types/getters";

export default {
    [IS_CURRENT_WEBSITE]: (state) => state.isCurrentWebsite,
    [GET_NEW_WEBSITE]: (state) => state.newWebsite ? state.newWebsite : undefined,
    [GET_SELECTED_WEBSITE]: (state) => state.selectedWebsite ? state.selectedWebsite : undefined,
    [GET_RELATE_WEBSITES]: (state) => state.relateUserWebsites,
    [GET_WEBSITE_DATA]: (state) => {
        return state.relateUserWebsites.find(website => website.id === state.selectedWebsite);
    },
};
