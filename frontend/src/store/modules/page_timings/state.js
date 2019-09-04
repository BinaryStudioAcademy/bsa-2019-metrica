import {
    AVG_PAGE_LOAD_TIME,
    AVG_LOOKUP_TIME,
    AVG_SERVER_RESPONSE_TIME,
} from '../../../configs/page_timings/buttonTypes.js';
import {period} from "@/services/periodService";

export default {
    selectedPeriod: period.PERIOD_LAST_WEEK,
    buttonData: {
        [AVG_PAGE_LOAD_TIME]: {
            value: 0,
            isFetching: false
        },
        [AVG_LOOKUP_TIME]: {
            value: 0,
            isFetching: false
        },
        [AVG_SERVER_RESPONSE_TIME]: {
            value: 0,
            isFetching: false
        }
    },
    chartData: {
        items: [],
        isFetching: false
    },
    activeButton: AVG_PAGE_LOAD_TIME,
    tableData: {
        items: [],
        isFetching: false,
        groupedParameter: 'browser'
    },
};
