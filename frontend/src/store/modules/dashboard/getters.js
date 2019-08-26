import {
    GET_SELECTED_PERIOD,
    GET_LINE_CHART_FETCHING,
    GET_LINE_CHART_DATA,
    GET_DATA_TYPE,
} from "./types/getters";

export default {
    [GET_SELECTED_PERIOD]: (state) => state.selectedPeriod,
    [GET_LINE_CHART_FETCHING]: (state) => state.chartData.isFetching,
    [GET_LINE_CHART_DATA]: (state) => state.chartData,
    [GET_DATA_TYPE]: (state) => state.dataToFetch,
};
