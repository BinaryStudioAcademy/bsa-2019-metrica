import {
    CHANGE_SELECTED_PERIOD,
    CHANGE_ACTIVE_BUTTON,
    CHANGE_FETCHED_BUTTON_STATE,
    FETCH_BUTTONS_DATA,
    FETCH_BUTTON_DATA,
    CHANGE_FETCHED_LINE_CHART_STATE,
    FETCH_LINE_CHART_DATA,
    CHANGE_GROUPED_PARAMETER,
    CHANGE_FETCHED_TABLE_STATE,
    FETCH_TABLE_DATA,
    FETCH_CHART_PIE_DATA,
    FETCH_PAGE_DATA
} from "./types/actions";
import {
    SET_SELECTED_PERIOD,
    SET_ACTIVE_BUTTON,
    SET_GROUPED_PARAMETER,
    RESET_BUTTON_FETCHING,
    SET_BUTTON_FETCHING,
    SET_BUTTON_DATA,
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
        context.dispatch(FETCH_PAGE_DATA);
    },
    [CHANGE_ACTIVE_BUTTON]: (context, button) => {
        context.commit(SET_ACTIVE_BUTTON, button);
        context.dispatch(FETCH_BUTTON_DATA, button);
        context.dispatch(FETCH_LINE_CHART_DATA);
        context.dispatch(FETCH_TABLE_DATA);

    },
    [CHANGE_FETCHED_BUTTON_STATE]: (context, data) => {
        if (data.value) {
            context.commit(SET_BUTTON_FETCHING, data.button);
        } else {
            context.commit(RESET_BUTTON_FETCHING, data.button);
        }
    },
    [FETCH_BUTTON_DATA]: (context, type) => {
        context.commit(SET_BUTTON_FETCHING, type);

        const period = getTimeByPeriod(context.state.selectedPeriod);
        const startDate = period.startDate;
        const endDate = period.endDate;
        const id = context.rootState.website.selectedWebsite;

        return factoryVisitorsService.create(type)
            .fetchButtonValue(startDate.unix(), endDate.unix(), id)
            .then(response => {
                context.commit(SET_BUTTON_DATA, {button: type, value: response.value});
                context.commit(RESET_BUTTON_FETCHING, type);
            })
            .finally(() => context.commit(RESET_BUTTON_FETCHING, type));
    },
    [CHANGE_FETCHED_LINE_CHART_STATE]: (context, value) => {

        if (value) {
            context.commit(SET_LINE_CHART_FETCHING);
        } else {
            context.commit(RESET_LINE_CHART_FETCHING);
        }
    },
    [FETCH_LINE_CHART_DATA]: (context) => {
        context.commit(SET_LINE_CHART_FETCHING);
        const period = getTimeByPeriod(context.state.selectedPeriod);
        const startDate = period.startDate;
        const endDate = period.endDate;
        const id = context.rootState.website.selectedWebsite;

        return factoryVisitorsService.create(context.state.activeButton)
            .fetchChartValues(startDate.unix(), endDate.unix(), period.interval, id)
            .then(data => context.commit(SET_LINE_CHART_DATA, data))
            .finally(() => context.commit(RESET_LINE_CHART_FETCHING));

    },
    [CHANGE_GROUPED_PARAMETER]: (context, parameter) => {
        context.commit(SET_GROUPED_PARAMETER, parameter);
        context.dispatch(FETCH_TABLE_DATA);
    },
    [CHANGE_FETCHED_TABLE_STATE]: (context, value) => {

        if (value) {
            context.commit(SET_TABLE_FETCHING);
        } else {
            context.commit(RESET_TABLE_FETCHING);
        }
    },
    [FETCH_TABLE_DATA]: (context) => {
        context.commit(SET_TABLE_FETCHING);
        const period = getTimeByPeriod(context.state.selectedPeriod);
        const startDate = period.startDate;
        const endDate = period.endDate;
        const id = context.rootState.website.selectedWebsite;

        return factoryVisitorsService.create(context.state.activeButton)
            .fetchTableValues(startDate.unix(), endDate.unix(), context.state.tableData.groupedParameter, id)
                .then(data => context.commit(SET_TABLE_DATA, data))
                .finally(() => context.commit(RESET_TABLE_FETCHING));
    },
    [FETCH_CHART_PIE_DATA]: (context) => {
        context.commit(SET_CHART_DATA_FETCHING);
        const period = getTimeByPeriod(context.state.selectedPeriod);
        const startDate = period.startDate;
        const endDate = period.endDate;
        const id = context.rootState.website.selectedWebsite;
        let newVisitors = 0;
        let totalVisitors = 0;
        let newVisitorsValue = 0;
        let returningVisitorsValue = 0;

        return newVisitorsService.fetchButtonValue(startDate.unix(), endDate.unix(), id)
            .then(response => {
                newVisitors = response.value;
               return totalVisitorsService.fetchButtonValue(startDate.unix(), endDate.unix(), id)
                    .then(response => {
                        totalVisitors = response.value || 0;
                       if (totalVisitors > 0) {
                            newVisitorsValue = Math.round(newVisitors/totalVisitors*100);
                            returningVisitorsValue = 100 - newVisitorsValue;
                        }
                        let payload = {
                            newVisitors: newVisitorsValue,
                            returningVisitors: returningVisitorsValue
                        };
                        context.commit(SET_CHART_PIE_DATA, payload);
                        context.commit(RESET_CHART_DATA_FETCHING);
                    });
            })
            .catch((response) => {
                context.commit(RESET_CHART_DATA_FETCHING);
                return Promise.reject(response);
            });
    },
    [FETCH_BUTTONS_DATA]: (context) => {
        Object.keys(context.state.buttonData).forEach((type) => {
            context.dispatch(FETCH_BUTTON_DATA, type);
        });
    },
    [FETCH_PAGE_DATA]: (context) => {
        context.dispatch(FETCH_TABLE_DATA);
        context.dispatch(FETCH_LINE_CHART_DATA);
        context.dispatch(FETCH_CHART_PIE_DATA);
        context.dispatch(FETCH_BUTTONS_DATA);

    }
};
