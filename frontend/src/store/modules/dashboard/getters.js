import {
    GET_SELECTED_PERIOD,
    GET_GROUPED_PARAMETER,
    GET_LINE_CHART_ITEMS,
    GET_LINE_CHART_FETCHING,
    GET_LINE_CHART_DATA,
} from "./types/getters";

export default {
    [GET_SELECTED_PERIOD]: (state) => state.selectedPeriod,
    [GET_GROUPED_PARAMETER]: (state) => state.tableData.groupedParameter,
    [GET_LINE_CHART_ITEMS]: (state) => state.chartData.items,
    [GET_LINE_CHART_FETCHING]: (state) => state.chartData.isFetching,
    [GET_LINE_CHART_DATA]: (state) => state.chartData,
};
