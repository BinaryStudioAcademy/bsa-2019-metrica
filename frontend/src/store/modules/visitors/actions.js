import {
    CHANGE_SELECTED_PERIOD,
    CHANGE_ACTIVE_BUTTON,
    CHANGE_FETCHED_BUTTON_STATE,
    GET_TABLE_DATA
} from "./types/actions";
import {
    SET_SELECTED_PERIOD,
    SET_ACTIVE_BUTTON,
    RESET_BUTTON_FETCHING,
    SET_BUTTON_FETCHING,
    GET_SELECTED_PERIOD,
    SET_TABLE_DATA,
    SET_TABLE_DATA_FETCHING,
    RESET_TABLE_DATA_FETCHING,
} from "./types/mutations";

import factoryVisitorService from '@/services/visitors/factoryVisitorsService';
import periodService from '@/services/periodService';
import {GET_ACTIVE_BUTTON} from "./types/getters";

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
    [GET_TABLE_DATA]: (context, data) => {
        if (data.value) {
            context.commit(SET_TABLE_DATA_FETCHING);
            context.commit(GET_ACTIVE_BUTTON)
                .then(response => {
                    data.button = response.data;
                });
            context.commit(GET_SELECTED_PERIOD)
                .then(response => {
                    periodService.getTimeByPeriod(response.data);
                })
                .then(response => {
                    factoryVisitorService.create(data.button)
                        .fetchTableValues(response.startDate, response.endDate, data.groupedParameter);
                })
                .then(response => {
                    context.commit(SET_TABLE_DATA, response.data);
                })
                .catch(err => {
                    context.commit(RESET_TABLE_DATA_FETCHING);
                    throw err;
                });
            context.commit(RESET_TABLE_DATA_FETCHING);
        }
    }
};
