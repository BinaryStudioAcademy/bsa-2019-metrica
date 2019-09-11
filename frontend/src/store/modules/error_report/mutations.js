import {
    SET_SELECTED_PERIOD,
    SET_CHART_VALUES,
    SET_CHART_FETCHING,
    RESET_CHART_FETCHING,
    SET_TABLE_DATA,
    SET_TABLE_FETCHING,
    RESET_TABLE_FETCHING,
} from "./types/mutations";

export default {
    [SET_SELECTED_PERIOD]: (state, period) => {
        state.selectedPeriod = period;
    },
    [SET_CHART_VALUES]: (state, items) => {
        state.chartData.items = items;
    },
    [SET_CHART_FETCHING]: (state) => {
        state.chartData.isFetching = true;
    },
    [RESET_CHART_FETCHING]: (state) => {
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
