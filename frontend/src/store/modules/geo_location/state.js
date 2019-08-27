import {period} from "@/services/periodService";

export default {
    selectedPeriod: period.PERIOD_LAST_WEEK,
    selectedParameter: 'all_visitors_count',
    geoLocationItems: {
        items: [],
        isFetching: false
    }
};
