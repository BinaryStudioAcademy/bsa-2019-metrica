import {GET_SELECTED_PERIOD, GET_TABLE_DATA_ITEMS, GET_TABLE_DATA_FETCHING, GET_GROUPED_PARAMETER} from "./types/getters";

export default {
    [GET_SELECTED_PERIOD]: (state) => state.selectedPeriod,
    [GET_TABLE_DATA_ITEMS]: (state) => state.tableData.items,
    [GET_TABLE_DATA_FETCHING]: (state) => state.tableData.isFetching,
    [GET_GROUPED_PARAMETER]: (state) =>state.tableData.groupedParameter
};