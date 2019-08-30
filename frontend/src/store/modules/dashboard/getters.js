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
import { BOUNCE_RATE } from "../../../configs/visitors/buttonTypes";

import moment from "moment";

function toFormat (interval) {
    switch (interval) {
        case period.PERIOD_TODAY:
        case period.PERIOD_YESTERDAY:
            return "HH:mm";
        case period.PERIOD_LAST_WEEK:
        case period.PERIOD_LAST_MONTH:
            return "MM/DD";
        default:
            return "MM/YYYY";
    }
}

function percentage(value) {
    return `${Math.round(value * 100)}%`;
}

export default {
    [GET_SELECTED_PERIOD]: (state) => state.selectedPeriod,
    [GET_LINE_CHART_FETCHING]: (state) => state.chartData.isFetching,
    [GET_LINE_CHART_DATA]: (state) => state.chartData,
    [GET_DATA_TYPE]: (state) => state.dataToFetch,
    [GET_ACTIVITY_DATA_ITEMS]: (state) => state.activityData.items,
    [GET_ACTIVITY_DATA_FETCHING]: (state) => state.activityData.isFetching,
    [GET_ACTIVITY_CHART_DATA]: (state) => state.activityChartData,
    [GET_FORMAT_LINE_CHART_DATA]: (state) => {
        const fromFormat = "DD/MM/YYYY H:mm:ss";
        return state.chartData.items.map(
            item => {
                return {
                    'date': moment(item.date, fromFormat).format(toFormat(state.selectedPeriod)),
                    'value': state.dataToFetch !== BOUNCE_RATE
                        ? item.value
                        : percentage(item.value)
                };
            });
    }
};
