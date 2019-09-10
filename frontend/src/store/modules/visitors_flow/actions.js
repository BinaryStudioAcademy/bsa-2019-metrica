import {
    CHANGE_SELECTED_PARAMETER,
    FETCH_VISITORS_FLOW
} from "./types/actions";
import {
    SET_SELECTED_PARAMETER,
    SET_VISITORS_FLOW,
    SET_IS_FETCHING,
    RESET_IS_FETCHING
} from "./types/mutations";
import { getVisitorsFlow } from '@/api/visitors_flow/visitorsFlowService';

export default {
    [CHANGE_SELECTED_PARAMETER]: (context, parameter) => {
        context.commit(SET_SELECTED_PARAMETER, parameter);
        context.dispatch(FETCH_VISITORS_FLOW);
    },
    [FETCH_VISITORS_FLOW]: context => {
        context.commit(SET_IS_FETCHING);

        return getVisitorsFlow(context.state.selectedParameter, context.state.currentLevel)
            .then(visitorsFlow => context.commit(SET_VISITORS_FLOW, visitorsFlow))
            .finally(() => context.commit(RESET_IS_FETCHING));
    }
};
