import {
    CHANGE_SELECTED_PERIOD,
    CHANGE_ACTIVE_BUTTON,
    CHANGE_FETCHED_BUTTON_STATE,
    GET_BUTTON_DATA
} from "./types/actions";
import {
    SET_SELECTED_PERIOD,
    SET_ACTIVE_BUTTON,
    RESET_BUTTON_FETCHING,
    SET_BUTTON_FETCHING,
    SET_BUTTON_DATA,
    GET_SELECTED_PERIOD
} from "./types/mutations";

import factoryVisitorService from '@/services/visitors/factoryVisitorsService';
import periodService from '@/services/periodService';

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
        if (data.value) {
            context.commit(SET_BUTTON_FETCHING, data.button);
            context.commit(GET_SELECTED_PERIOD)
                .then(response => {
                    periodService.getTimeByPeriod(response.data);
                })
                .then(response => {
                    factoryVisitorService.create(data.button)
                        .fetchButtonValue(response.startDate, response.endDate);
                })
                .then(response => {
                    context.commit(SET_BUTTON_DATA, data.button, response.data);
                })
                .catch(err => {
                    context.commit(RESET_BUTTON_FETCHING, data.button);
                    throw err;
                });
            context.commit(RESET_BUTTON_FETCHING, data.button);
        }
    }
};
