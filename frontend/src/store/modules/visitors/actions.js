import {
    CHANGE_SELECTED_PERIOD,
    CHANGE_ACTIVE_BUTTON,
    CHANGE_FETCHED_BUTTON_STATE,
    GET_LINE_CHART_DATA,
    CHANGE_GROUPED_PARAMETER,
    CHANGE_FETCHED_TABLE_STATE
} from "./types/actions";
import {
    SET_SELECTED_PERIOD,
    SET_GROUPED_PARAMETER,
    SET_ACTIVE_BUTTON,
    RESET_BUTTON_FETCHING,
    SET_BUTTON_FETCHING,
    RESET_TABLE_FETCHING,
    SET_TABLE_FETCHING
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
    [GET_LINE_CHART_DATA]: (context, data) => {
        if (!data.value) {
            return;
        }

        context.commit(SET_LINE_CHART_DATA_FETCHING);
        context.commit(GET_SELECTED_PERIOD)
            .then(response => {
                periodService.getTimeByPeriod(response.data);
            })
            .then(response => {
                factoryVisitorService.create(data.button)
                    .fetchLineChartValue(response.startDate, response.endDate);
            })
            .then(response => {
                context.commit(SET_LINE_CHART_DATA, response.data);
            })
            .catch(err => {
                context.commit(RESET_LINE_CHART_DATA_FETCHING, data.button);
                throw err;
            });
        context.commit(RESET_BUTTON_FETCHING);
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
