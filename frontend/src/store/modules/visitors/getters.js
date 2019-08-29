import {
    GET_SELECTED_PERIOD,
    GET_BUTTON_DATA,
    GET_ACTIVE_BUTTON,
    GET_PIE_CHART_DATA,
    GET_TABLE_DATA_ITEMS,
    GET_TABLE_DATA_FETCHING,
    GET_GROUPED_PARAMETER,
    GET_LINE_CHART_ITEMS,
    GET_LINE_CHART_FETCHING,
    GET_LINE_CHART_DATA,
    FETCH_TABLE_DATA,
    GET_FETCHED_PAGE_STATE
} from "./types/getters";
import moment from 'moment';

export default {
    [GET_SELECTED_PERIOD]: (state) => state.selectedPeriod,
    [GET_BUTTON_DATA]: (state) => state.buttonData,
    /*[GET_BUTTON_DATA]: (state) => {
        return Object.keys(state.buttonData).map((key) => {
            if (key === 'avg_session') {
                return { ...state.buttonData[key], value: moment.unix(state.buttonData[key].value).format("HH:mm:ss")};
            }
            return state.buttonData[key];
        });
    },*/
    [GET_ACTIVE_BUTTON]: (state) => state.activeButton,
    [GET_PIE_CHART_DATA]: (state) => state.pieChartData,
    [GET_TABLE_DATA_ITEMS]: (state) => {
        if (state.activeButton === 'avg_session') {
            return state.tableData.items.map((item) => {
                return { ...item, total: moment.unix(item.total).format("HH:mm:ss")};
            });
        }
    },
    [GET_TABLE_DATA_FETCHING]: (state) => state.tableData.isFetching,
    [GET_GROUPED_PARAMETER]: (state) => state.tableData.groupedParameter,
    [GET_LINE_CHART_ITEMS]: (state) => state.chartData.items,
    [GET_LINE_CHART_FETCHING]: (state) => state.chartData.isFetching,
    [GET_LINE_CHART_DATA]: (state) => state.chartData,
    [FETCH_TABLE_DATA]: (state) => state.tableData,
    [GET_FETCHED_PAGE_STATE]: (state) => state.isFetchedPageData,
};
