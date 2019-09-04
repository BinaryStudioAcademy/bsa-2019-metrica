import {
    GET_SELECTED_PERIOD,
    GET_BUTTON_DATA,
    GET_ACTIVE_BUTTON,
    GET_PIE_CHART_DATA,
    GET_TABLE_DATA_ITEMS,
    GET_TABLE_DATA_FETCHING,
    GET_GROUPED_PARAMETER,
    GET_LINE_CHART_FETCHING,
    GET_LINE_CHART_DATA,
    GET_FORMAT_LINE_CHART_DATA,
    FETCH_TABLE_DATA,
} from "./types/getters";

import moment from 'moment';
import { chartDataTransformer } from "@/api/widgets/transformers";

export default {
    [GET_SELECTED_PERIOD]: (state) => state.selectedPeriod,
    [GET_BUTTON_DATA]: (state) => state.buttonData,
    [GET_ACTIVE_BUTTON]: (state) => state.activeButton,
    [GET_PIE_CHART_DATA]: (state) => state.pieChartData,
    [GET_TABLE_DATA_ITEMS]: (state) => {

            return state.tableData.items.map((item) => {
                if (state.activeButton === 'avg_session') {
                    const duration = moment.duration(parseInt(item.total, 10), 'ms');
                    const hours = Math.ceil(duration.asHours());
                    const minutes = moment.utc(duration.asMilliseconds()).format("mm:ss");
                    let newItem = {
                        total: `${hours}:${minutes}`,
                        percentage: Math.round(Number(item.percentage))
                    };
                    return {...item, ...newItem};
                }
                return {...item, percentage: Math.round(Number(item.percentage))};
            });
    },
    [GET_TABLE_DATA_FETCHING]: (state) => state.tableData.isFetching,
    [GET_GROUPED_PARAMETER]: (state) => state.tableData.groupedParameter,
    [GET_LINE_CHART_FETCHING]: (state) => state.chartData.isFetching,
    [GET_LINE_CHART_DATA]: (state) => state.chartData,
    [FETCH_TABLE_DATA]: (state) => state.tableData,
    [GET_FORMAT_LINE_CHART_DATA]: (state) => {
        state.chartData.items.sort((a, b) => a.date - b.date);
        return chartDataTransformer(state.chartData.items, state.selectedPeriod);
    },
};
