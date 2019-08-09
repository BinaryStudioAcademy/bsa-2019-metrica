import {GET_CURRENT_WEBSITE} from "./types/getters";

export default {
    [GET_CURRENT_WEBSITE]: (state) => state.currentWebsite ? state.currentWebsite : undefined,

};