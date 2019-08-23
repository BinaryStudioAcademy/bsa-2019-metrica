import {
    CHANGE_SELECTED_PERIOD,
    CHANGE_ACTIVE_BUTTON,
    CHANGE_FETCHED_BUTTON_STATE,
    FETCH_BUTTON_DATA,
    GET_EACH_BUTTON_DATA
} from "./types/actions";
import {
    SET_SELECTED_PERIOD,
    SET_ACTIVE_BUTTON,
    RESET_BUTTON_FETCHING,
    SET_BUTTON_FETCHING,
    SET_BUTTON_DATA,
    GET_BUTTON_DATA
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
    }

};
