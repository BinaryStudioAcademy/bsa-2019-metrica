import {GET_SELECTED_PERIOD, GET_BUTTON_DATA, GET_ACTIVE_BUTTON} from "./types/getters";

export default {
    [GET_SELECTED_PERIOD]: (state) => state.selectedPeriod,
    [GET_BUTTON_DATA]: (state) => state.buttonData,
    [GET_ACTIVE_BUTTON]: (state) => state.activeButton
};
