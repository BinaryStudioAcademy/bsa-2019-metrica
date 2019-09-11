import {
    CHANGE_SELECTED_PERIOD,
    FETCH_PAGE_DATA,
    FETCH_CHART_DATA,
    FETCH_TABLE_DATA,
} from "./types/actions";

import {
    SET_SELECTED_PERIOD,
    SET_CHART_VALUES,
    RESET_CHART_FETCHING,
    SET_CHART_FETCHING,
    RESET_TABLE_FETCHING,
    SET_TABLE_FETCHING,
    SET_TABLE_DATA,
} from "./types/mutations";
import {getErrorTableItems, getChartValues} from '@/api/error_report/errorsService';
import {getTimeByPeriod} from '@/services/periodService';

export default {
    [CHANGE_SELECTED_PERIOD]: (context, payload) => {
        context.commit(SET_SELECTED_PERIOD, payload.value);
        context.dispatch(FETCH_PAGE_DATA);
    },
    [FETCH_PAGE_DATA]: (context) => {
        context.dispatch(FETCH_CHART_DATA);
        context.dispatch(FETCH_TABLE_DATA);
    },

    [FETCH_CHART_DATA]: (context) => {
        context.commit(SET_CHART_FETCHING);

        const period = getTimeByPeriod(context.state.selectedPeriod);

        return getChartValues(period.startDate.unix(), period.endDate.unix(), period.interval)
            .then(data => context.commit(SET_CHART_VALUES, data))
            .finally(() => context.commit(RESET_CHART_FETCHING));
    },
    [FETCH_TABLE_DATA]: (context) => {
        context.commit(SET_TABLE_FETCHING);

        const period = getTimeByPeriod(context.state.selectedPeriod);
        const parameter = 'page';

        return getErrorTableItems(period.startDate.unix(), period.endDate.unix(), parameter)
            .then(getErrorTableItems => context.commit(SET_TABLE_DATA, getErrorTableItems))
            .finally(() => context.commit(RESET_TABLE_FETCHING));
    },
};
