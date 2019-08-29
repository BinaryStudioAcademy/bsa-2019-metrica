import {
    TOTAL_VISITORS,
    NEW_VISITORS,
    AVG_SESSION,
    PAGE_VIEWS,
    SESSIONS,
    BOUNCE_RATE
} from '../../../configs/visitors/buttonTypes.js';
import {period} from "@/services/periodService";

export default {
    selectedPeriod: period.PERIOD_LAST_WEEK,
    buttonData: {
        [TOTAL_VISITORS]: {
            value: 0,
            isFetching: false
        },
        [NEW_VISITORS]: {
            value: 0,
            isFetching: false
        },
        [SESSIONS]: {
            value: 0,
            isFetching: false
        },
        [AVG_SESSION]: {
            value: 0,
            isFetching: false
        },
        [PAGE_VIEWS]: {
            value: 0,
            isFetching: false
        },
        [BOUNCE_RATE]: {
            value: 0,
            isFetching: false
        },
    },
    chartData: {
        items: [],
        isFetching: false
    },
    pieChartData: {
        newVisitors: 50,
        returnVisitors: 50,
        isFetching: false
    },
    activeButton: TOTAL_VISITORS,
    tableData: {
        items: [],
        isFetching: false,
        groupedParameter: 'browser'
    },
    isFetchedPageData: false
};
