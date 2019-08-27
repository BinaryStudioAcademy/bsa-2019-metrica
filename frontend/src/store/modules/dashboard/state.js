import {period} from "../../../services/periodService";

export default {
    selectedPeriod: period.PERIOD_LAST_WEEK,
    chartData: {
        items: [],
        isFetching: false
    },
    dataToFetch: 'total_visitors',
    activityData:{
        items: [],
        isFetching: false
    },
    activityChartData:[]
};
