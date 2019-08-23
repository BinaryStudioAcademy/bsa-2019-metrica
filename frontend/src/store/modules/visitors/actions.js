import {
    CHANGE_SELECTED_PERIOD,
    CHANGE_GROUPED_PARAMETER,
    CHANGE_ACTIVE_BUTTON,
    CHANGE_FETCHED_BUTTON_STATE,
    FETCH_BUTTON_DATA,
    GET_EACH_BUTTON_DATA,
    CHANGE_FETCHED_TABLE_STATE
} from "./types/actions";
import {
    SET_SELECTED_PERIOD,
    SET_ACTIVE_BUTTON,
    SET_GROUPED_PARAMETER,
    RESET_BUTTON_FETCHING,
    SET_BUTTON_FETCHING,
    SET_BUTTON_DATA,
    GET_BUTTON_DATA,
    RESET_TABLE_FETCHING,
    SET_TABLE_FETCHING
} from "./types/mutations";

import factoryVisitorService from '../../../services/visitors/factoryVisitorsService';
import periodService from '@/services/periodService';
import buttonTypes from '@/configs/visitors/buttonTypes';

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
    [FETCH_BUTTON_DATA]: (context, data) => {
        if (!data.value) {
            return;
        }
        context.commit(SET_BUTTON_FETCHING, data.button);

        periodService(context.state.selectedPeriod)
            .then(response => {
                factoryVisitorService.create(data.button)
                    .fetchButtonValue(response.startDate, response.endDate);
            })
            .then(response => {
                context.commit(SET_BUTTON_DATA, data.button, response.data);
                context.commit(RESET_BUTTON_FETCHING, data.button);
            })
            .catch(err => {
                context.commit(RESET_BUTTON_FETCHING, data.button);
                throw err;
            });

    },
    [GET_EACH_BUTTON_DATA]: (context) => {
        let allData = [];
        buttonTypes.forEach(function (type) {
            allData.push(context.commit(GET_BUTTON_DATA, type), type);
        });
        return allData;
    },
    [CHANGE_GROUPED_PARAMETER]: (context, parameter) => {
        context.commit(SET_GROUPED_PARAMETER, parameter);
    },
    [CHANGE_FETCHED_TABLE_STATE]: (context, value) => {

        if (value) {
            context.commit(SET_TABLE_FETCHING);
        } else {
            context.commit(RESET_TABLE_FETCHING);
        }
    },
};
