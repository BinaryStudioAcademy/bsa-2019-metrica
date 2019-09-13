import {
    CHANGE_SELECTED_PERIOD,
    CHANGE_ACTIVE_BUTTON,
    CHANGE_FETCHED_BUTTON_STATE,
    FETCH_PAGE_DATA,
    FETCH_BUTTONS_DATA,
    FETCH_CHART_DATA,
    FETCH_BUTTON_DATA,
    FETCH_PAGE_VIEWS_TABLE_DATA,
    CHANGE_DEFAULT_PERIOD
} from "./types/actions";

import {getTimeByPeriod} from "@/services/periodService";
import {fetchTableValues} from '@/api/page_views/tablePageViewsService';
import {factoryPageViewsService} from "../../../api/page_views/factoryPageViewsService";

import {
    SET_SELECTED_PERIOD,
    SET_ACTIVE_BUTTON,
    RESET_BUTTON_FETCHING,
    SET_BUTTON_FETCHING,
    SET_BUTTON_VALUE,
    SET_CHART_VALUES,
    SET_CHART_FETCHING,
    RESET_CHART_FETCHING,
    SET_IS_FETCHING,
    RESET_IS_FETCHING,
    SET_PAGE_VIEWS_TABLE_DATA
} from "./types/mutations";

export default {
    [CHANGE_SELECTED_PERIOD]: (context, payload) => {
        context.commit(SET_SELECTED_PERIOD, payload.value);
        context.dispatch(FETCH_PAGE_DATA);
        context.dispatch(FETCH_PAGE_VIEWS_TABLE_DATA);
    },
    [CHANGE_ACTIVE_BUTTON]: (context, button) => {
        context.commit(SET_ACTIVE_BUTTON, button);
        context.dispatch(FETCH_BUTTON_DATA, button);
        context.dispatch(FETCH_CHART_DATA);
    },
    [CHANGE_FETCHED_BUTTON_STATE]: (context, data) => {

        if (data.value) {
            context.commit(SET_BUTTON_FETCHING, data.button);
        } else {
            context.commit(RESET_BUTTON_FETCHING, data.button);
        }
    },
    [FETCH_PAGE_DATA]: (context) => {
        context.dispatch(FETCH_BUTTONS_DATA);
        context.dispatch(FETCH_CHART_DATA);
    },

    [FETCH_BUTTONS_DATA]: (context) => {
        Object.keys(context.state.buttonData).forEach((type) => {
            context.dispatch(FETCH_BUTTON_DATA, type);
        });
    },

    [FETCH_BUTTON_DATA]: (context, type) => {
        context.commit(SET_BUTTON_FETCHING, type);

        const period = getTimeByPeriod(context.state.selectedPeriod);

        factoryPageViewsService.create(type).fetchButtonValue(
            period.startDate.unix(),
            period.endDate.unix()
        ).then(response => {
            let payload = {
                buttonType: type,
                value: response.value
            };
            context.commit(SET_BUTTON_VALUE, payload);
        }).finally(() => context.commit(RESET_BUTTON_FETCHING, type));
    },

    [FETCH_CHART_DATA]: (context) => {
        const time = getTimeByPeriod(context.state.selectedPeriod);
        context.commit(SET_CHART_FETCHING);
        factoryPageViewsService.create(context.state.activeButton).fetchChartValues(
            time.startDate.unix(),
            time.endDate.unix(),
            time.interval
        ).then(response => {
                context.commit(SET_CHART_VALUES, response);
                context.commit(RESET_CHART_FETCHING);
            }
        ).finally(() => context.commit(RESET_CHART_FETCHING));
    },

    [FETCH_PAGE_VIEWS_TABLE_DATA]: (context) => {
        context.commit(SET_IS_FETCHING);

        const period = getTimeByPeriod(context.state.selectedPeriod);

        return fetchTableValues(period.startDate.unix(), period.endDate.unix())
            .then(response => context.commit(SET_PAGE_VIEWS_TABLE_DATA, response))
            .finally(() => context.commit(RESET_IS_FETCHING));
    },

    [CHANGE_DEFAULT_PERIOD]: (context, period) => {
        context.commit(SET_SELECTED_PERIOD, period);
    }
};
