import {
    CHANGE_SELECTED_PERIOD,
    CHANGE_ACTIVE_BUTTON,
    CHANGE_FETCHED_BUTTON_STATE,
    CHANGE_FETCHED_LINE_CHART_STATE,
    FETCH_LINE_CHART_DATA,
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
    SET_TABLE_FETCHING,
    RESET_LINE_CHART_FETCHING,
    SET_LINE_CHART_FETCHING,
    SET_LINE_CHART_DATA,
} from "./types/mutations";

// import factoryVisitorService from '@/services/visitors/factoryVisitorsService';
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
    [CHANGE_FETCHED_LINE_CHART_STATE]: (context, value) => {

        if (value) {
            context.commit(SET_LINE_CHART_FETCHING);
        } else {
            context.commit(RESET_LINE_CHART_FETCHING);
        }
    },
    [FETCH_LINE_CHART_DATA]: (context, data) => {
        if (!data.value) {
            return;
        }
        context.commit(SET_LINE_CHART_FETCHING);

        periodService.getTimeByPeriod(context.state.selectedPeriod)
            .then(response => {
                return factoryVisitorService.create(context.state.activeButton)
                    .fetchLineChartValues(response.startDate, response.endDate, data.groupedParameter);
            })
            .then(response => {
                context.commit(SET_LINE_CHART_DATA, response.data);
                context.commit(RESET_LINE_CHART_FETCHING);
            })
            .catch(err => {
                context.commit(RESET_LINE_CHART_FETCHING);
                throw err;
            });
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
