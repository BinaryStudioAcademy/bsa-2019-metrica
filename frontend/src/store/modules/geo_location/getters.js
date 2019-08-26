import {
    GET_SELECTED_PERIOD,
    GET_SELECTED_PARAMETER,
    GET_GEO_LOCATION_ITEMS
} from "./types/getters";

export default {
    [GET_SELECTED_PERIOD]: (state) => state.selectedPeriod,
    [GET_SELECTED_PARAMETER]: (state) => state.selectedParameter,
    [GET_GEO_LOCATION_ITEMS]: (state) => state.geoLocationItems
};