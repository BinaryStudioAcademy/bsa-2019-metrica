import {
    CHANGE_SELECTED_PERIOD,
    CHANGE_FETCHED_BUTTON_STATE,
    FETCH_PAGE_DATA,
    FETCH_CHART_DATA,
} from "./types/actions";

//import {getTimeByPeriod} from "@/services/periodService";

import {
    SET_SELECTED_PERIOD,
    RESET_BUTTON_FETCHING,
    SET_BUTTON_FETCHING,
    SET_CHART_VALUES,
    //RESET_CHART_FETCHING,
} from "./types/mutations";

export default {
    [CHANGE_SELECTED_PERIOD]: (context, payload) => {
        context.commit(SET_SELECTED_PERIOD, payload.value);
        context.dispatch(FETCH_PAGE_DATA);
    },
    [CHANGE_FETCHED_BUTTON_STATE]: (context, data) => {

        if (data.value) {
            context.commit(SET_BUTTON_FETCHING, data.button);
        } else {
            context.commit(RESET_BUTTON_FETCHING, data.button);
        }
    },
    [FETCH_PAGE_DATA]: (context) => {
        context.dispatch(FETCH_CHART_DATA);
    },

    [FETCH_CHART_DATA]: (context) => {
       // const time = getTimeByPeriod(context.state.selectedPeriod);
       // context.commit(SET_CHART_FETCHING);

        console.log(context);
        const items = [
            {
                date:'1565700000',
                value:2,
            },
            {
                date:'1565820000',
                value:2,
            },
        ];
        context.commit(SET_CHART_VALUES, items);
        /*fetchChartValues(
            time.startDate.unix(),
            time.endDate.unix(),
            time.interval
        ).then(response => {
                context.commit(SET_CHART_VALUES, response);
                context.commit(RESET_CHART_FETCHING);
            }
        ).finally(() => context.commit(RESET_CHART_FETCHING));*/
    },
};
