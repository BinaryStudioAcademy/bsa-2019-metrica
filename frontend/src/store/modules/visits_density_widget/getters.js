import {
    GET_SELECTED_PERIOD,
    GET_VISITS_DATA,
    IS_FETCHING
} from "./types/getters";

export default {
    [GET_SELECTED_PERIOD]: (state) => state.selectedPeriod,
    [GET_VISITS_DATA]: (state) => state.visitsData.items,
    [IS_FETCHING]: (state) => state.visitsData.isFetching,
};
