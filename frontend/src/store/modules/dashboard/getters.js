import {
    GET_SELECTED_PERIOD,
    GET_LINE_CHART_FETCHING,
    GET_LINE_CHART_DATA,
    GET_DATA_TYPE,
    GET_ACTIVITY_DATA_ITEMS,
    GET_ACTIVITY_CHART_DATA,
    GET_ACTIVITY_DATA_FETCHING,
    GET_FORMAT_LINE_CHART_DATA
} from "./types/getters";

import { period } from "../../../services/periodService";
import moment from "moment";

export default {
    [GET_SELECTED_PERIOD]: (state) => state.selectedPeriod,
    [GET_LINE_CHART_FETCHING]: (state) => state.chartData.isFetching,
    [GET_LINE_CHART_DATA]: (state) => state.chartData,
    [GET_DATA_TYPE]: (state) => state.dataToFetch,
    [GET_ACTIVITY_DATA_ITEMS]: (state) => state.activityData.items,
    [GET_ACTIVITY_DATA_FETCHING]: (state) => state.activityData.isFetching,
    [GET_ACTIVITY_CHART_DATA]: (state) => state.activityChartData,
    [GET_FORMAT_LINE_CHART_DATA]: (state) => {
        const interval = state.selectedPeriod;
        const format = "DD/MM/YYYY H:mm:ss";
        switch (interval) {
            case period.PERIOD_TODAY:
            case period.PERIOD_YESTERDAY:
                return state.chartData.items.map(item => {
                    return {
                        'date': moment(item.date, format).format("HH:mm"),
                        'value': item.value
                    };
                });
            default:
                return state.chartData.items.map(item => {
                    const value = Number(item.value);
                    return {
                        'date': moment(item.date, format).format("MM/DD/YYYY"),
                        'value': Number.isInteger(value) ? value : value.toFixed(2)
                    };
                });
        }
    }
};
