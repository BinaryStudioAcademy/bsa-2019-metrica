import {SET_BUTTON_FETCHING, SET_ACTIVITY_DATA_ITEMS, RESET_BUTTON_FETCHING, SET_ACTIVITY_CHART_DATA} from "./types/mutations";

export default {
    [SET_ACTIVITY_DATA_ITEMS]: (state, data) => {
        state.activityData.items = data;
    },
    [SET_BUTTON_FETCHING]: (state) => {
        state.activityData.isFetching = true;
    },
    [RESET_BUTTON_FETCHING]: (state) => {
        state.activityData.isFetching = false;
    },
    [SET_ACTIVITY_CHART_DATA]: (state, data) => {
        state.activityChartData = data;
    },
};
