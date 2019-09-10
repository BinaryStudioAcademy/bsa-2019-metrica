import {
    CHANGE_SELECTED_PERIOD,
    CHANGE_FETCHED_LINE_CHART_STATE,
    FETCH_LINE_CHART_DATA,
    CHANGE_FETCHED_TABLE_STATE,
    FETCH_TABLE_DATA,
    FETCH_PAGE_DATA
} from "./types/actions";
import {
    SET_SELECTED_PERIOD,
    RESET_TABLE_FETCHING,
    SET_TABLE_FETCHING,
    RESET_LINE_CHART_FETCHING,
    SET_LINE_CHART_FETCHING,
} from "./types/mutations";

import {getTimeByPeriod} from '@/services/periodService';

export default {
    [CHANGE_SELECTED_PERIOD]: (context, payload) => {
        context.commit(SET_SELECTED_PERIOD, payload.value);
        context.dispatch(FETCH_PAGE_DATA);
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
        context.commit(RESET_LINE_CHART_FETCHING)
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
        context.commit(RESET_TABLE_FETCHING)
    },
    [FETCH_PAGE_DATA]: (context) => {
        context.dispatch(FETCH_TABLE_DATA);
        context.dispatch(FETCH_LINE_CHART_DATA);
    }
};
