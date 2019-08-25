import {
    GET_ACTIVITY_DATA_ITEMS,
    GET_ACTIVITY_CHART_DATA,
    GET_ACTIVITY_DATA_FETCHING,
} from "./types/getters";

export default {
    [GET_ACTIVITY_DATA_ITEMS]: (state) => state.activityData.items,
    [GET_ACTIVITY_DATA_FETCHING]: (state) => state.activityData.isFetching,
    [GET_ACTIVITY_CHART_DATA]: (state) => state.activityChartData,
};
