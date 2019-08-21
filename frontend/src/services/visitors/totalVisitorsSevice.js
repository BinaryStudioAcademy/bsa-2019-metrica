import requestService from "../requestService";
import config from "@/config";
import {buttonTransformer} from './transformers';

const resourceUrl = config.getApiUrl();

const fetchButtonValue = (startDate, endDate) => {
    return requestService.get(resourceUrl + '/button-visitors', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate
    }).then(response => buttonTransformer(response.data))
        .catch(err => alert(err));
};

const fetchChartValues = (startDate, endDate, interval) => {
    return requestService.get(resourceUrl+'/')
};
// const fetchTableValues = (startDate, endDate, groupBy) => {
// };

const totalVisitorsService = {
    fetchButtonValue,
    // fetchChartValues,
    // fetchTableValues
};

export default totalVisitorsService;