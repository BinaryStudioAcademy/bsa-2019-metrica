import {
    SET_SELECTED_PERIOD,
    SET_GROUPED_PARAMETER,
    SET_ACTIVE_BUTTON,
    SET_BUTTON_FETCHING,
    RESET_BUTTON_FETCHING,
    SET_BUTTON_DATA,
    GET_SELECTED_PERIOD,
    GET_BUTTON_DATA,
    SET_TABLE_FETCHING,
    RESET_TABLE_FETCHING
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
    [SET_BUTTON_DATA]: (state, button, value) => {
        state.buttonData[button].value = value;
    },
    [GET_SELECTED_PERIOD]: (state) => {
        return state.selectedPeriod;
    },
    [GET_BUTTON_DATA]: (state, type) => {
        return state.buttonData[type];
    },
    [SET_GROUPED_PARAMETER]: (state, parameter) => {
        state.tableData.groupedParameter = parameter;
    },
    [SET_TABLE_FETCHING]: (state) => {
        state.tableData.isFetching = true;
    },
    [RESET_TABLE_FETCHING]: (state) => {
        state.tableData.isFetching = false;
    },
};