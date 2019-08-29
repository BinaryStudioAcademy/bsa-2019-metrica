import {
    GET_SELECTED_PERIOD,
    GET_BUTTON_DATA,
    GET_ACTIVE_BUTTON,
    GET_LINE_CHART_DATA,
    GET_PAGE_VIEWS_TABLE_DATA,
    IS_FETCHING
} from "./types/getters";

export default {
    [GET_SELECTED_PERIOD]: (state) => state.selectedPeriod,
    [GET_BUTTON_DATA]: (state) => state.buttonData,
    [GET_ACTIVE_BUTTON]: (state) => state.activeButton,
    [GET_LINE_CHART_DATA]: (state) => state.chartData,
    [GET_PAGE_VIEWS_TABLE_DATA]: (state) => state.pageViewsTableData.items,
    [IS_FETCHING]: (state) => state.pageViewsTableData.isFetching,
};
