import {
    CHANGE_SELECTED_PERIOD,
    CHANGE_ACTIVE_BUTTON,
    CHANGE_FETCHED_BUTTON_STATE,
    FETCH_PAGE_VIEWS_TABLE_DATA
} from "./types/actions";
import {
    SET_SELECTED_PERIOD,
    SET_ACTIVE_BUTTON,
    RESET_BUTTON_FETCHING,
    SET_BUTTON_FETCHING,
    SET_IS_FETCHING,
    RESET_IS_FETCHING,
    SET_PAGE_VIEWS_TABLE_DATA
} from "./types/mutations";
import {getTimeByPeriod} from '@/services/periodService';
import {fetchTableValues} from '@/api/page_views/tablePageViewsService';

export default {
    [CHANGE_SELECTED_PERIOD]: (context, payload) => {
        context.commit(SET_SELECTED_PERIOD, payload.value);
        context.dispatch(FETCH_PAGE_VIEWS_TABLE_DATA);
    },
    [CHANGE_ACTIVE_BUTTON]: (context, button) => {
        context.commit(SET_ACTIVE_BUTTON, button);
    },
    [CHANGE_FETCHED_BUTTON_STATE]: (context, data) => {

        if (data.value) {
            context.commit(SET_BUTTON_FETCHING, data.button);
        } else {
            context.commit(RESET_BUTTON_FETCHING, data.button);
        }
    },
    [FETCH_PAGE_VIEWS_TABLE_DATA]: (context) => {
        context.commit(SET_IS_FETCHING);

        const period = getTimeByPeriod(context.state.selectedPeriod);

        return fetchTableValues(period.startDate.unix(), period.endDate.unix())
            .then(response => context.commit(SET_PAGE_VIEWS_TABLE_DATA, response))
            .finally(() => context.commit(RESET_IS_FETCHING));
    }
};
