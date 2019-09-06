import {
    GET_SELECTED_PERIOD,
    GET_BUTTON_DATA,
    GET_ACTIVE_BUTTON,
    GET_TABLE_DATA_ITEMS,
    GET_TABLE_DATA_FETCHING,
    GET_GROUPED_PARAMETER,
    GET_LINE_CHART_FETCHING,
    GET_LINE_CHART_DATA,
    GET_FORMAT_LINE_CHART_DATA,
    GET_TABLE_DATA,
} from "./types/getters";

import { chartDataTransformer } from "@/api/widgets/transformers";

export default {
    [GET_SELECTED_PERIOD]: (state) => state.selectedPeriod,
    [GET_BUTTON_DATA]: (state) => state.buttonData,
    [GET_ACTIVE_BUTTON]: (state) => state.activeButton,
    [GET_TABLE_DATA_ITEMS]: (state) => state.tableData.items,
    [GET_TABLE_DATA_FETCHING]: (state) => state.tableData.isFetching,
    [GET_GROUPED_PARAMETER]: (state) => state.tableData.groupedParameter,
    [GET_LINE_CHART_FETCHING]: (state) => state.chartData.isFetching,
    [GET_LINE_CHART_DATA]: (state) => state.chartData,
    [GET_TABLE_DATA]: (state) => state.tableData,
    [GET_FORMAT_LINE_CHART_DATA]: (state) => {
        return chartDataTransformer(state.chartData.items, state.selectedPeriod);
    },
};
