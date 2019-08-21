import {CHANGE_SELECTED_PERIOD, CHANGE_ACTIVE_BUTTON, CHANGE_FETCHED_BUTTON_STATE} from "./types/actions";
import {SET_SELECTED_PERIOD, SET_ACTIVE_BUTTON, RESET_BUTTON_FETCHING, SET_BUTTON_FETCHING} from "./types/mutations";
import {GET_BUTTON_DATA} from "./types/getters";

export default {
    [CHANGE_SELECTED_PERIOD]: (context, payload) => {
        context.commit(SET_SELECTED_PERIOD, payload.value);
    },
    [CHANGE_ACTIVE_BUTTON]: (context, button) => {
        context.commit(SET_ACTIVE_BUTTON, button);
    },
    [CHANGE_FETCHED_BUTTON_STATE]: (context, button) => {

        if (context.getters[GET_BUTTON_DATA][button].isFetching) {
            context.commit(RESET_BUTTON_FETCHING, button);
        } else {
            context.commit(SET_BUTTON_FETCHING, button);
        }
    },
};
