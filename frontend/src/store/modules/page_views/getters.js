import {
    GET_SELECTED_PERIOD,
    GET_BUTTON_DATA,
    GET_ACTIVE_BUTTON,
    GET_LINE_CHART_DATA,
    GET_FORMAT_LINE_CHART_DATA
} from "./types/getters";

import {period} from '@/services/periodService';
import moment from 'moment';

export default {
    [GET_SELECTED_PERIOD]: (state) => state.selectedPeriod,
    [GET_BUTTON_DATA]: (state) => state.buttonData,
    [GET_ACTIVE_BUTTON]: (state) => state.activeButton,
    [GET_LINE_CHART_DATA]: (state) => state.chartData,
    [GET_FORMAT_LINE_CHART_DATA]: (state) => {
        const interval = state.selectedPeriod;
        switch (interval) {
            case period.PERIOD_TODAY:
            case period.PERIOD_YESTERDAY:
                return state.chartData.items.map(item => {
                    return {
                        'date': moment.unix(item.date).format("HH:mm"),
                        'value': item.value
                    };
                });
            default:
                return state.chartData.items.map(item => {
                    return {
                        'date': moment.unix(item.date).format("MM/DD/YYYY"),
                        'value': item.value
                    };
                });
        }
    }
};
