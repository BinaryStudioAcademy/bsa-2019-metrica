import {
    CHANGE_SELECTED_PERIOD,
    CHANGE_ACTIVE_BUTTON,
    CHANGE_FETCHED_BUTTON_STATE,
    CHANGE_FETCHED_LINE_CHART_STATE,
    FETCH_LINE_CHART_DATA,
    CHANGE_GROUPED_PARAMETER,
    CHANGE_FETCHED_TABLE_STATE,
    FETCH_TABLE_DATA,
    FETCH_CHART_PIE_DATA
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
    SET_TABLE_DATA,
    SET_CHART_PIE_DATA,
    SET_CHART_DATA_FETCHING,
    RESET_CHART_DATA_FETCHING
} from "./types/mutations";

import {newVisitorsService} from "@/api/visitors/newVisitorsService";
import {totalVisitorsService} from "@/api/visitors/totalVisitorsService";
import {factoryVisitorsService} from '@/api/visitors/factoryVisitorsService';
import {getTimeByPeriod} from '@/services/periodService';

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
        const period = getTimeByPeriod(context.state.selectedPeriod);
        const startDate = period.startDate;
        const endDate = period.endDate;

        return factoryVisitorsService.create(context.state.activeButton)
            .fetchChartValues(startDate.unix(), endDate.unix(), data.groupedParameter)
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
    [FETCH_TABLE_DATA]: (context, data) => {
        if (!data.value) {
            return;
        }
        context.commit(SET_TABLE_FETCHING);

        getTimeByPeriod(context.state.selectedPeriod)
            .then(response => {
                return factoryVisitorsService.create(context.state.activeButton)
                    .fetchTableValues(response.startDate, response.endDate, data.groupedParameter);
            })
            .then(response => {
                context.commit(SET_TABLE_DATA, response.data);
                context.commit(RESET_TABLE_FETCHING);
            })
            .catch(err => {
                context.commit(RESET_TABLE_FETCHING);
                throw err;
            });
    },
    [FETCH_CHART_PIE_DATA]: (context) => {
        context.commit(SET_CHART_DATA_FETCHING);
        const period = getTimeByPeriod(context.state.selectedPeriod);
        const startDate = period.startDate;
        const endDate = period.endDate;
        let newVisitors = 0;
        let returnVisitors = 0;

        return newVisitorsService.fetchButtonValue(startDate.unix(), endDate.unix())
            .then(response => {
                newVisitors = response.value;
               return totalVisitorsService.fetchButtonValue(startDate.unix(), endDate.unix())
                    .then(response => {
                        returnVisitors = response.value;
                        newVisitors = (newVisitors/returnVisitors*100);
                        returnVisitors = 100 - newVisitors;
                        context.commit(SET_CHART_PIE_DATA, {newVisitors, returnVisitors});
                        context.commit(RESET_CHART_DATA_FETCHING);
                    });
            })
            .catch((response) => {
                context.commit(RESET_CHART_DATA_FETCHING);
                return Promise.reject(response);
            });
    },
};
