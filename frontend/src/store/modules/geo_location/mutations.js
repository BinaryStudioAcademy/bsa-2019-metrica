import {
    SET_SELECTED_PERIOD,
    SET_SELECTED_PARAMETER,
    SET_GEO_LOCATION_ITEMS
} from "./types/mutations";

export default {
    [SET_SELECTED_PERIOD]: (state, period) => {
        state.selectedPeriod = period;
    },
    [SET_SELECTED_PARAMETER]: (state, parameter) => {
        state.selectedParameter = parameter;
    },
    [SET_GEO_LOCATION_ITEMS]: (state, geoLocationItems) => {
        state.geoLocationItems = geoLocationItems;
    }
};
