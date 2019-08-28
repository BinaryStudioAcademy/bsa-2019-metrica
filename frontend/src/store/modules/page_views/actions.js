import {
    CHANGE_SELECTED_PERIOD,
    CHANGE_ACTIVE_BUTTON,
    CHANGE_FETCHED_BUTTON_STATE,
    GET_BUTTON_DATA
} from "./types/actions";

import {factoryPageViewsService} from "../../../api/page_views/factoryPageViewsService";

import {SET_SELECTED_PERIOD, SET_ACTIVE_BUTTON, RESET_BUTTON_FETCHING, SET_BUTTON_FETCHING} from "./types/mutations";

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
    [GET_BUTTON_DATA]: (context, data) => {
        //1. фетчим дял всех кнопок
        data.buttonTypes.map((type) => {
            alert(type);
                factoryPageViewsService.create(type).fetchButtonValue();
        });

    }
};
