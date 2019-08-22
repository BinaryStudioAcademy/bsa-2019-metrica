import {CHANGE_SELECTED_PERIOD, CHANGE_GROUPED_PARAMETER, CHANGE_ACTIVE_BUTTON, CHANGE_FETCHED_BUTTON_STATE} from "./types/actions";
import {SET_SELECTED_PERIOD, SET_GROUPED_PARAMETER, SET_ACTIVE_BUTTON, RESET_BUTTON_FETCHING, SET_BUTTON_FETCHING} from "./types/mutations";

export default {
    [CHANGE_SELECTED_PERIOD]: (context, payload) => {
        context.commit(SET_SELECTED_PERIOD, payload.value);
    },
    [CHANGE_ACTIVE_BUTTON]: (context, button) => {
        context.commit(SET_ACTIVE_BUTTON, button);
    },
    [CHANGE_FETCHED_BUTTON_STATE]: (context, data) => {

        if (data.value) {
            context.commit(SET_BUTTON_FETCHING, data.button);
        } else {
            context.commit(RESET_BUTTON_FETCHING, data.button);
        }
    },
    [CHANGE_GROUPED_PARAMETER]: (context, parameter) => {
        context.commit(SET_GROUPED_PARAMETER, parameter);
    }
};
