import {
    GET_SELECTED_PERIOD,
    GET_SELECTED_PARAMETER,
    GET_GEO_LOCATION_ITEMS,
    IS_FETCHING
} from "./types/getters";

export default {
    [GET_SELECTED_PERIOD]: (state) => state.selectedPeriod,
    [GET_SELECTED_PARAMETER]: (state) => state.selectedParameter,
    [GET_GEO_LOCATION_ITEMS]: (state) => state.geoLocationItems.items,
    [IS_FETCHING]: (state) => state.geoLocationItems.isFetching
};
