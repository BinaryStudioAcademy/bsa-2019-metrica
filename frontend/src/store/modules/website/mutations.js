import {SET_WEBSITE} from "./types/mutations";

export default {
    [SET_WEBSITE]: (state, website) => {state.website = website;},
};
