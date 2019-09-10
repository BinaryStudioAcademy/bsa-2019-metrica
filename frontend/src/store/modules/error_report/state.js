import {period} from "@/services/periodService";

export default {
    selectedPeriod: period.PERIOD_LAST_WEEK,
    chartData: {
        items: [],
        isFetching: false
    },
    tableData: {
        items: [],
        isFetching: false,
    },
};
