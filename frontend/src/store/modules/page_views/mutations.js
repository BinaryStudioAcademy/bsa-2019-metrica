import {
    SET_SELECTED_PERIOD,
    SET_ACTIVE_BUTTON,
    SET_BUTTON_FETCHING,
    RESET_BUTTON_FETCHING,
    SET_BUTTON_VALUE,
    SET_CHART_VALUES,
    SET_CHART_FETCHING,
    RESET_CHART_FETCHING,
    SET_PAGE_VIEWS_TABLE_DATA,
    SET_IS_FETCHING,
    RESET_IS_FETCHING
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
    [SET_PAGE_VIEWS_TABLE_DATA]: (state, data) => {
        state.pageViewsTableData.items = data;
    },
    [SET_IS_FETCHING]: (state) => {
        state.pageViewsTableData.isFetching = true;
    },
    [RESET_IS_FETCHING]: (state) => {
        state.pageViewsTableData.isFetching = false;
    },
    [SET_BUTTON_VALUE]: (state, payload) => {
        state.buttonData[payload.buttonType].value = payload.value;
    },
    [SET_CHART_VALUES]: (state, items) => {
        state.chartData.items = items;
    },
    [SET_CHART_FETCHING]: (state) => {
        state.chartData.isFetching = true;
    },
    [RESET_CHART_FETCHING]: (state) => {
        state.chartData.isFetching = false;
    }
};
