import {
    SET_SELECTED_PERIOD,
    SET_ACTIVE_BUTTON,
    SET_BUTTON_FETCHING,
    RESET_BUTTON_FETCHING,
    SET_TABLE_DATA,
    GET_SELECTED_PERIOD,
    SET_TABLE_DATA_FETCHING,
    RESET_TABLE_DATA_FETCHING,
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
    [GET_SELECTED_PERIOD]: (state) => {
        return state.selectedPeriod;
    },
    [SET_TABLE_DATA]: (state, value) => {
        state.tableData.items = value;
    },
    [SET_TABLE_DATA_FETCHING]: (state) => {
        state.tableData.isFetching = true;
    },
    [RESET_TABLE_DATA_FETCHING]: (state) => {
        state.tableData.isFetching = false;
    },
};
