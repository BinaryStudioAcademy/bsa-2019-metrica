import {
    GET_NEW_WEBSITE,
    IS_CURRENT_WEBSITE,
    GET_SELECTED_WEBSITE,
    GET_RELATE_WEBSITES,
} from "./types/getters";

export default {
    [IS_CURRENT_WEBSITE]: (state) => state.isCurrentWebsite,
    [GET_NEW_WEBSITE]: (state) => state.newWebsite ? state.newWebsite : undefined,
    [GET_SELECTED_WEBSITE]: (state) => state.selectedWebsite ? state.selectedWebsite : '',
    [GET_RELATE_WEBSITES]: (state) => state.relateUserWebsites,
};
