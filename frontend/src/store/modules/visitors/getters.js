import {
    GET_SELECTED_PERIOD,
    GET_BUTTON_DATA,
    GET_ACTIVE_BUTTON,
    GET_PIE_CHART_DATA,
    GET_LINE_CHART_DATA,
    GET_TABLE_DATA_ITEMS,
    GET_TABLE_DATA_FETCHING,
    GET_GROUPED_PARAMETER
} from "./types/getters";

export default {
    [GET_SELECTED_PERIOD]: (state) => state.selectedPeriod,
    [GET_BUTTON_DATA]: (state) => state.buttonData,
    [GET_ACTIVE_BUTTON]: (state) => state.activeButton,
    [GET_PIE_CHART_DATA]: (state) => state.pieChartData,
    [GET_LINE_CHART_DATA]: (state) => state.chartData,
    [GET_TABLE_DATA_ITEMS]: (state) => state.tableData.items,
    [GET_TABLE_DATA_FETCHING]: (state) => state.tableData.isFetching,
    [GET_GROUPED_PARAMETER]: (state) => state.tableData.groupedParameter
};
