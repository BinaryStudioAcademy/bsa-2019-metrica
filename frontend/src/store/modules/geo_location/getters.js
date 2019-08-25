import {
    GET_SELECTED_PERIOD,
    GET_SELECTED_PARAMETER,
} from "./types/getters";

export default {
    [GET_SELECTED_PERIOD]: (state) => state.selectedPeriod,
    [GET_SELECTED_PARAMETER]: (state) => state.selectedParameter
};