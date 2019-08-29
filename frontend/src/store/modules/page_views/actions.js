import {
    CHANGE_SELECTED_PERIOD,
    CHANGE_ACTIVE_BUTTON,
    CHANGE_FETCHED_BUTTON_STATE,
    FETCH_PAGE_DATA,
    FETCH_BUTTONS_DATA,
    FETCH_CHART_DATA,
    FETCH_BUTTON_DATA
} from "./types/actions";

import {getTimeByPeriod} from "@/services/periodService";


import {factoryPageViewsService} from "../../../api/page_views/factoryPageViewsService";

import {
    SET_SELECTED_PERIOD,
    SET_ACTIVE_BUTTON,
    RESET_BUTTON_FETCHING,
    SET_BUTTON_FETCHING,
    SET_BUTTON_VALUE,
    SET_CHART_VALUES, SET_CHART_FETCHING, RESET_CHART_FETCHING
} from "./types/mutations";

export default {
    [CHANGE_SELECTED_PERIOD]: (context, payload) => {
        context.commit(SET_SELECTED_PERIOD, payload.value);
        context.dispatch(FETCH_PAGE_DATA);
    },
    [CHANGE_ACTIVE_BUTTON]: (context, button) => {
        context.commit(SET_ACTIVE_BUTTON, button);
        const time = getTimeByPeriod(context.state.selectedPeriod);
        context.dispatch(FETCH_CHART_DATA, time);
    },
    [CHANGE_FETCHED_BUTTON_STATE]: (context, data) => {

        if (data.value) {
            context.commit(SET_BUTTON_FETCHING, data.button);
        } else {
            context.commit(RESET_BUTTON_FETCHING, data.button);
        }
    },
    [FETCH_PAGE_DATA]: (context) => {
        alert(context.state.selectedPeriod);
        const time = getTimeByPeriod(context.state.selectedPeriod);
        context.dispatch(FETCH_BUTTONS_DATA, time);
        context.dispatch(FETCH_CHART_DATA, time);
    },

    [FETCH_BUTTONS_DATA]: (context, time) => {
        Object.keys(context.state.buttonData).map((type) => {
            context.dispatch(FETCH_BUTTON_DATA, {
                time: time,
                type: type
            });
        });
    },

    [FETCH_BUTTON_DATA]: (context, button) => {
        context.commit(SET_BUTTON_FETCHING, button.type);
        factoryPageViewsService.create(button.type).fetchButtonValue(
            button.time.startDate.unix(),
            button.time.endDate.unix()
        ).then(response => {
            let payload = {
                buttonType: button.type,
                value: response.value
            };
            context.commit(SET_BUTTON_VALUE, payload);
            context.commit(RESET_BUTTON_FETCHING, button.type);
        }).catch(error => {
            context.commit(RESET_BUTTON_FETCHING, button.type);
            throw  error;
        });
    },

    [FETCH_CHART_DATA]: (context, time) => {
        context.commit(SET_CHART_FETCHING);
        factoryPageViewsService.create(context.state.activeButton).fetchChartValues(
            time.startDate.unix(),
            time.endDate.unix(),
            time.interval
        ).then(response => {
                context.commit(SET_CHART_VALUES, response);
                context.commit(RESET_CHART_FETCHING);
            }
        ).catch(error => {
            context.commit(RESET_CHART_FETCHING);
            throw  error;
        });
    }
};
