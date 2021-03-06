import {
    CHANGE_SELECTED_PERIOD,
    CHANGE_ACTIVE_BUTTON,
    FETCH_BUTTONS_DATA,
    FETCH_BUTTON_DATA,
    FETCH_LINE_CHART_DATA,
    CHANGE_GROUPED_PARAMETER,
    CHANGE_FETCHED_TABLE_STATE,
    FETCH_TABLE_DATA,
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
} from "./types/mutations";

import {factoryPageTimingsService} from '@/api/page_timings/factoryPageTimingsService';
import {getTimeByPeriod} from '@/services/periodService';

export default {
    [CHANGE_SELECTED_PERIOD]: (context, payload) => {
        if (context.state.selectedPeriod === payload.value) {
            return;
        }
        context.commit(SET_SELECTED_PERIOD, payload.value);
        context.dispatch(FETCH_PAGE_DATA);
    },
    [CHANGE_ACTIVE_BUTTON]: (context, button) => {
        context.commit(SET_ACTIVE_BUTTON, button);
        context.dispatch(FETCH_LINE_CHART_DATA);
        context.dispatch(FETCH_TABLE_DATA);

    },
    [FETCH_BUTTON_DATA]: (context, type) => {
        context.commit(SET_BUTTON_FETCHING, type);

        const period = getTimeByPeriod(context.state.selectedPeriod);
        const startDate = period.startDate;
        const endDate = period.endDate;

        return factoryPageTimingsService.create(type)
            .fetchButtonValue(startDate.unix(), endDate.unix())
            .then(response => {
                context.commit(SET_BUTTON_DATA, {button: type, value: response.value});
                context.commit(RESET_BUTTON_FETCHING, type);
            })
            .catch(err => {
                context.commit(RESET_BUTTON_FETCHING, type);
                throw err;
            });
    },
    [FETCH_LINE_CHART_DATA]: (context) => {
        context.commit(SET_LINE_CHART_FETCHING);
        const period = getTimeByPeriod(context.state.selectedPeriod);
        const startDate = period.startDate;
        const endDate = period.endDate;

        return factoryPageTimingsService.create(context.state.activeButton)
            .fetchChartValues(startDate.unix(), endDate.unix(), period.interval)
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

        return factoryPageTimingsService.create(context.state.activeButton)
            .fetchTableValues(startDate.unix(), endDate.unix(), context.state.tableData.groupedParameter)
                .then(data => context.commit(SET_TABLE_DATA, data))
                .finally(() => context.commit(RESET_TABLE_FETCHING));
    },
    [FETCH_BUTTONS_DATA]: (context) => {
        Object.keys(context.state.buttonData).forEach((type) => {
            context.dispatch(FETCH_BUTTON_DATA, type);
        });
    },
    [FETCH_PAGE_DATA]: (context) => {
        context.dispatch(FETCH_TABLE_DATA);
        context.dispatch(FETCH_LINE_CHART_DATA);
        context.dispatch(FETCH_BUTTONS_DATA);

    }
};
