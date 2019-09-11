import {
    SET_SELECTED_PARAMETER,
    SET_CURRENT_LEVEL,
    SET_VISITORS_FLOW,
    PUSH_VISITORS_FLOW,
    SET_IS_FETCHING,
    RESET_IS_FETCHING
} from "./types/mutations";

export default {
    [SET_SELECTED_PARAMETER]: (state, parameter) => {
        state.selectedParameter = parameter;
    },
    [SET_CURRENT_LEVEL]: (state, level) => {
        state.currentLevel = level;
    },
    [SET_VISITORS_FLOW]: (state, visitorsFlow) => {
        state.visitorsFlow.items = visitorsFlow;
    },
    [PUSH_VISITORS_FLOW]: (state, visitorsFlow) => {
        state.visitorsFlow.items = [...state.visitorsFlow.items, ...visitorsFlow];
    },
    [SET_IS_FETCHING]: (state) => {
        state.visitorsFlow.isFetching = true;
    },
    [RESET_IS_FETCHING]: (state) => {
        state.visitorsFlow.isFetching = false;
    }
};
