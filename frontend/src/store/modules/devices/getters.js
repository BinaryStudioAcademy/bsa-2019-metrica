import {
    GET_SELECTED_PERIOD,
    GET_WIDGET_DATA,
    GET_FETCHING_STATUS
} from "./types/getters";

export default {
    [GET_SELECTED_PERIOD]: (state) => state.selectedPeriod,
    [GET_WIDGET_DATA]: (state) => state.data,
    [GET_FETCHING_STATUS]: (state) => state.isFetching
};