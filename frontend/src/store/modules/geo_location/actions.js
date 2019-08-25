import {CHANGE_SELECTED_PERIOD} from "./types/actions";
import {SET_SELECTED_PERIOD} from "./types/mutations";

export default {
    [CHANGE_SELECTED_PERIOD]: (context, payload) => {
        context.commit(SET_SELECTED_PERIOD, payload.value);
    }
};