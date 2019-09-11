import {
    GET_SELECTED_PARAMETER,
    GET_CURRENT_LEVEL,
    GET_VISITORS_FLOW,
    IS_FETCHING
} from "./types/getters";

export default {
    [GET_SELECTED_PARAMETER]: state => state.selectedParameter,
    [GET_CURRENT_LEVEL]: state => state.currentLevel,
    [GET_VISITORS_FLOW]: state => state.visitorsFlow.items,
    [IS_FETCHING]: state => state.visitorsFlow.isFetching
};
