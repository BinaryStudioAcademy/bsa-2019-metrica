import {
    GET_SELECTED_PERIOD,
    GET_BUTTON_DATA,
    GET_ACTIVE_BUTTON,
    GET_LINE_CHART_DATA,
    GET_FORMAT_LINE_CHART_DATA,
} from "./types/getters";

import { chartDataTransformer } from "@/api/widgets/transformers";

export default {
    [GET_SELECTED_PERIOD]: (state) => state.selectedPeriod,
    [GET_BUTTON_DATA]: (state) => state.buttonData,
    [GET_ACTIVE_BUTTON]: (state) => state.activeButton,
    [GET_LINE_CHART_DATA]: (state) => state.chartData,
    [GET_FORMAT_LINE_CHART_DATA]: (state) => {
        return chartDataTransformer(state.chartData.items, state.selectedPeriod);
    },
};
