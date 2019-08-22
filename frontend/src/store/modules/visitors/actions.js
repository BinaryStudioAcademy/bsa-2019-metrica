import {
    CHANGE_SELECTED_PERIOD,
    CHANGE_ACTIVE_BUTTON,
    CHANGE_FETCHED_BUTTON_STATE,
    CHANGE_TABLE_DATA
} from "./types/actions";
import {
    SET_SELECTED_PERIOD,
    SET_ACTIVE_BUTTON,
    RESET_BUTTON_FETCHING,
    SET_BUTTON_FETCHING,
    SET_TABLE_DATA
} from "./types/mutations";

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
    [CHANGE_TABLE_DATA]: (context, payload) => {
        context.commit(SET_TABLE_DATA, payload);
        alert('hello!');
        //  getAuthUser().then(response => {
        //     const user = response.data[0];
        //     alert(user)
        // })
        //     .catch(() => alert('error!'));
    }
};
