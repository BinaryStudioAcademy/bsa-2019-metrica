import {
    SET_SELECTED_PERIOD,
    SET_LINE_CHART_DATA,
    SET_LINE_CHART_FETCHING,
    RESET_LINE_CHART_FETCHING,
    SET_TABLE_DATA,
    SET_TABLE_FETCHING,
    RESET_TABLE_FETCHING,
} from "./types/mutations";

export default {
    [SET_SELECTED_PERIOD]: (state, period) => {
        state.selectedPeriod = period;
    },
    [SET_LINE_CHART_DATA]: (state, value) => {
        state.chartData.items = value;
    },
    [SET_LINE_CHART_FETCHING]: (state) => {
        state.chartData.isFetching = true;
    },
    [RESET_LINE_CHART_FETCHING]: (state) => {
        state.chartData.isFetching = false;
    },
    [SET_TABLE_DATA]: (state, value) => {
        state.tableData.items = value;
    },
    [SET_TABLE_FETCHING]: (state) => {
        state.tableData.isFetching = true;
    },
    [RESET_TABLE_FETCHING]: (state) => {
        state.tableData.isFetching = false;
    },
};
