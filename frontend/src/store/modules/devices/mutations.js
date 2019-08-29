import {
    SET_SELECTED_PERIOD,
    SET_DATA_FETCHING,
    RESET_DATA_FETCHING,
    SET_WIDGET_DATA
} from "./types/mutations";

export default {
    [SET_SELECTED_PERIOD]: (state, period) => {
        state.selectedPeriod = period.value;
    },
    [SET_WIDGET_DATA]: (state, data) => {
        state.data = data;
    },
    [SET_DATA_FETCHING]: (state) => {
        state.isFetching = true;
    },
    [RESET_DATA_FETCHING]:(state) => {
        state.isFetching = false;
    }
};