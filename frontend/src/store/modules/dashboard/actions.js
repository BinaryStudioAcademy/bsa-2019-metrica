import {
    CHANGE_SELECTED_PERIOD,
    CHANGE_FETCHED_LINE_CHART_STATE,
    CHANGE_GROUPED_PARAMETER,
    FETCH_LINE_CHART_DATA
} from "./types/actions";
import {
    RESET_LINE_CHART_FETCHING,
    SET_LINE_CHART_FETCHING,
    SET_LINE_CHART_DATA,
    SET_SELECTED_PERIOD,
    SET_GROUPED_PARAMETER
} from "./types/mutations";

import {factoryVisitorsService} from '@/api/visitors/factoryVisitorsService';
import {getTimeByPeriod} from '@/services/periodService';

export default {
    [CHANGE_SELECTED_PERIOD]: (context, payload) => {
        context.commit(SET_SELECTED_PERIOD, payload.value);
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
        console.log("period.interval: ", period.interval);
        const startDate = period.startDate;
        console.log("start date: ", startDate.unix());
        const endDate = period.endDate;
        console.log("end date: ", endDate.unix());

        return factoryVisitorsService.create("total_visitors")
            .fetchChartValues(startDate.unix(), endDate.unix(), period.interval)
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
    }
};
