import {
    SET_SELECTED_PERIOD,
    SET_VISITS_DATA,
    SET_IS_FETCHING,
    RESET_IS_FETCHING
} from "./types/mutations";

export default {
    [SET_SELECTED_PERIOD]: (state, period) => {
        state.selectedPeriod = period;
    },
    [SET_VISITS_DATA]: (state, items) => {
        state.visitsData.items = items;
    },
    [SET_IS_FETCHING]: (state) => {
        state.visitsData.isFetching = true;
    },
    [RESET_IS_FETCHING]: (state) => {
        state.visitsData.isFetching = false;
    }
};
