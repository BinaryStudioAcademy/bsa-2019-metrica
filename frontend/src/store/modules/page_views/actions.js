import {
    CHANGE_SELECTED_PERIOD,
    CHANGE_ACTIVE_BUTTON,
    CHANGE_FETCHED_BUTTON_STATE,
    FETCH_PAGE_DATA,
    FETCH_BUTTONS_DATA,
    FETCH_CHART_DATA,
    FETCH_BUTTON_DATA
} from "./types/actions";

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
    [FETCH_PAGE_DATA]: (context, data) => {
        context.dispatch(FETCH_BUTTONS_DATA, data);
        context.dispatch(FETCH_CHART_DATA, data);
    },

    [FETCH_BUTTONS_DATA]: (context, data) => {
        Object.keys(context.state.buttonData).map((type) => {
            context.dispatch(FETCH_BUTTON_DATA, {
                data: data,
                type: type
            });
        });
    },

    [FETCH_BUTTON_DATA]: (context, button) => {
        context.commit(SET_BUTTON_FETCHING, button.type);
        factoryPageViewsService.create(button.type).fetchButtonValue(
            button.data.time.startDate.unix(),
            button.data.time.endDate.unix()
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

    [FETCH_CHART_DATA]: (context, data) => {
        context.commit(SET_CHART_FETCHING);
        factoryPageViewsService.create(context.state.activeButton).fetchChartValues(
            data.time.startDate.unix(),
            data.time.endDate.unix(),
            data.time.interval
        ).then(response => {
                context.commit(SET_CHART_VALUES, response);
                context.commit(RESET_CHART_FETCHING);
            }
        ).catch(error=>{
            context.commit(RESET_CHART_FETCHING);
            throw  error;
        });
    }
};
