import {ADD_WEBSITE} from "./types/mutations";

export default {
    [ADD_WEBSITE]: (state, website) => {
        state.currentWebsite = website;
    },
}