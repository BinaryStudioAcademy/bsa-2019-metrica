import {CHANGE_SELECTED_PERIOD, CHANGE_GROUPED_PARAMETER} from "./types/actions";
import {SET_SELECTED_PERIOD, SET_GROUPED_PARAMETER} from "./types/mutations";

export default {
    [CHANGE_SELECTED_PERIOD]: (context, payload) => {
        context.commit(SET_SELECTED_PERIOD, payload.value);
    },
    [CHANGE_GROUPED_PARAMETER]: (context, parameter) => {
        context.commit(SET_GROUPED_PARAMETER, parameter);
    }
};
