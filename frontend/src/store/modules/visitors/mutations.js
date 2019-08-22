import {SET_SELECTED_PERIOD, SET_GROUPED_PARAMETER} from "./types/mutations";

export default {
    [SET_SELECTED_PERIOD]: (state, period) => {
        state.selectedPeriod = period;
    },
    [SET_GROUPED_PARAMETER]: (state, parameter) => {
        state.tableData.groupedParameter = parameter;
    }
};