import {
    GET_CURRENT_WEBSITE,
    GET_NEW_WEBSITE,
    IS_CURRENT_WEBSITE,
    GET_SELECTED_WEBSITE,
    GET_RELATE_WEBSITES
} from "./types/getters";

export default {
    [IS_CURRENT_WEBSITE]: (state) => state.isCurrentWebsite,
    [GET_CURRENT_WEBSITE]: (state) => state.currentWebsite ? state.currentWebsite : undefined,
    [GET_NEW_WEBSITE]: (state) => state.newWebsite ? state.newWebsite : undefined,
    [GET_SELECTED_WEBSITE]: (state) => state.relateUserWebsites.selectedWebsite,
    [GET_RELATE_WEBSITES]: (state) => state.relateUserWebsites.websites,
};
