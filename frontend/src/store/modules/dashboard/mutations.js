import {
    SET_SELECTED_PERIOD,
    SET_LINE_CHART_DATA,
    SET_LINE_CHART_FETCHING,
    RESET_LINE_CHART_FETCHING,
    SET_GROUPED_PARAMETER
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
    [SET_GROUPED_PARAMETER]: (state, parameter) => {
        state.tableData.groupedParameter = parameter;
    }
};
