import {
    CHANGE_SELECTED_PERIOD,
    CHANGE_GROUPED_PARAMETER,
    CHANGE_ACTIVE_BUTTON,
    CHANGE_FETCHED_BUTTON_STATE,
    CHANGE_FETCHED_TABLE_STATE,
    GET_CHART_DATA
} from "./types/actions";
import {
    SET_SELECTED_PERIOD,
    SET_GROUPED_PARAMETER,
    SET_ACTIVE_BUTTON,
    RESET_BUTTON_FETCHING,
    SET_BUTTON_FETCHING,
    RESET_TABLE_FETCHING,
    SET_TABLE_FETCHING,
    SET_CHART_DATA,
    SET_CHART_DATA_FETCHING,
    RESET_CHART_DATA_FETCHING
} from "./types/mutations";
import {getTimeByPeriod} from "../../../services/periodService";
import {newVisitorsService} from "../../../api/visitors/newVisitorsService";
import {totalVisitorsService} from "../../../api/visitors/totalVisitorsService";

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
    },
    [CHANGE_FETCHED_TABLE_STATE]: (context, value) => {

        if (value) {
            context.commit(SET_TABLE_FETCHING);
        } else {
            context.commit(RESET_TABLE_FETCHING);
        }
    },
    [GET_CHART_DATA]: (context) => {
        context.commit(SET_CHART_DATA_FETCHING);
        const period = getTimeByPeriod(context.state.selectedPeriod);
        const startDate = period.startDate;
        const endDate = period.endDate;
        let newVisitors = 0;
        let returnVisitors = 0;

        return newVisitorsService.fetchButtonValue(startDate.unix(), endDate.unix())
            .then(response => {
                newVisitors = response.value;
                totalVisitorsService.fetchButtonValue(startDate.unix(), endDate.unix())
                    .then(response => {
                        returnVisitors = response.value;
                        newVisitors = (newVisitors/returnVisitors*100);
                        returnVisitors = 100 - newVisitors;
                        context.commit(SET_CHART_DATA, {newVisitors, returnVisitors});
                        context.commit(RESET_CHART_DATA_FETCHING);
                    }).catch((response) => {
                        context.commit(RESET_CHART_DATA_FETCHING);
                        return Promise.reject(response);
                });
            })
            .catch((response) => {
                context.commit(RESET_CHART_DATA_FETCHING);
                return Promise.reject(response);
            });
    },
};
