import {
    SET_SELECTED_PERIOD,
    SET_LINE_CHART_DATA,
    GET_SELECTED_PERIOD,
    SET_LINE_CHART_FETCHING,
    RESET_LINE_CHART_FETCHING,
    SET_GROUPED_PARAMETER,
    SET_ACTIVE_BUTTON,
    SET_BUTTON_FETCHING,
    RESET_BUTTON_FETCHING,
    SET_BUTTON_DATA,
    GET_BUTTON_DATA,
    SET_TABLE_DATA,
    SET_TABLE_FETCHING,
    RESET_TABLE_FETCHING,
    SET_CHART_PIE_DATA,
    SET_CHART_DATA_FETCHING,
    RESET_CHART_DATA_FETCHING
} from "./types/mutations";

export default {
    [SET_SELECTED_PERIOD]: (state, period) => {
        state.selectedPeriod = period;
    },
    [SET_ACTIVE_BUTTON]: (state, button) => {
        state.activeButton = button;
    },
    [SET_BUTTON_FETCHING]: (state, button) => {
        state.buttonData[button].isFetching = true;
    },
    [RESET_BUTTON_FETCHING]: (state, button) => {
        state.buttonData[button].isFetching = false;
    },
    [SET_BUTTON_DATA]: (state, button, value) => {
        state.buttonData[button].value = value;
    },
    [GET_SELECTED_PERIOD]: (state) => {
        return state.selectedPeriod;
    },
    [GET_BUTTON_DATA]: (state, type) => {
        return state.buttonData[type];
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
    [SET_GROUPED_PARAMETER]: (state, parameter) => {
        state.tableData.groupedParameter = parameter;
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
    [SET_CHART_PIE_DATA]: (state, {newVisitors, returnVisitors}) => {
        state.pieChartData.newVisitors = newVisitors;
        state.pieChartData.returnVisitors = returnVisitors;
    },
    [SET_CHART_DATA_FETCHING]: (state) => {
        state.pieChartData.isFetching = true;
    },
    [RESET_CHART_DATA_FETCHING]: (state) => {
        state.pieChartData.isFetching = false;
    },
};
