import {
    CHANGE_SELECTED_PERIOD,
    CHANGE_ACTIVE_BUTTON,
    CHANGE_FETCHED_BUTTON_STATE,
    GET_BUTTON_DATA
} from "./types/actions";

import {factoryPageViewsService} from "../../../api/page_views/factoryPageViewsService";

import {
    SET_SELECTED_PERIOD,
    SET_ACTIVE_BUTTON,
    RESET_BUTTON_FETCHING,
    SET_BUTTON_FETCHING,
    SET_BUTTON_VALUE,
    SET_CHART_VALUES
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
    [GET_BUTTON_DATA]: (context, data) => {
        data.buttonTypes.map((type) => {
            factoryPageViewsService.create(type).fetchButtonValue(
                data.time.startDate.unix(),
                data.time.endDate.unix()
            ).then(response => {
                let payload = {
                    buttonType: type,
                    value: response.value
                };
                context.commit(SET_BUTTON_VALUE, payload);
            });
        });

        return factoryPageViewsService.create(data.activeButton).fetchChartValues(
            data.time.startDate.unix(),
            data.time.endDate.unix(),
            data.time.interval
        ).then(response => {
                context.commit(SET_CHART_VALUES, response);
                return response;
            }
        );
    }
};
