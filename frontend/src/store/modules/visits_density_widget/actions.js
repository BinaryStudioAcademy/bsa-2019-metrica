import {
    CHANGE_SELECTED_PERIOD,
    FETCH_WIDGET_DATA
} from "./types/actions";
import {
    SET_SELECTED_PERIOD,
    SET_VISITS_DATA,
    SET_IS_FETCHING,
    RESET_IS_FETCHING
} from "./types/mutations";

import {getVisitsDensity} from '@/api/visits';
import {getTimeByPeriod} from '@/services/periodService';
import moment from "moment";

export default {
    [CHANGE_SELECTED_PERIOD]: (context, payload) => {
        if (context.state.selectedPeriod === payload.value) {
            return;
        }
        context.commit(SET_SELECTED_PERIOD, payload.value);
        context.dispatch(FETCH_WIDGET_DATA);
    },
    [FETCH_WIDGET_DATA]: (context) => {
        context.commit(SET_IS_FETCHING);

        const period = getTimeByPeriod(context.state.selectedPeriod);
        const timeZone = moment().format('Z');

        return getVisitsDensity(period.startDate.unix(), period.endDate.unix(), timeZone)
            .then(getVisitsData => context.commit(SET_VISITS_DATA, getVisitsData))
            .finally(() => context.commit(RESET_IS_FETCHING));
    }
};
