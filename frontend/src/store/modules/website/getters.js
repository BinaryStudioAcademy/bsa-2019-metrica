import {GET_CURRENT_WEBSITE, GET_NEW_WEBSITE} from "./types/getters";

export default {
    [GET_CURRENT_WEBSITE]: (state) => state.currentWebsite ? state.currentWebsite : undefined,
    [GET_NEW_WEBSITE]: (state) => state.newWebsite ? state.newWebsite : undefined,
};
