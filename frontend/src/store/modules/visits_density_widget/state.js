import {period} from "@/services/periodService";

export default {
    selectedPeriod: period.PERIOD_LAST_WEEK,
    visitsData: {
        items: [],
        isFetching: false //true
    }
};
