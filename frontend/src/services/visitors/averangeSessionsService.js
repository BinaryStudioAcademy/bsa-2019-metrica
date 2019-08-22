import requestService from "../requestService";
import config from "@/config";
import {buttonTransformer, chartTransformer} from './transformers';

const resourceUrl = config.getApiUrl();

const fetchButtonValue = (startDate, endDate) => {
    return requestService.get(resourceUrl + '/sessions/average', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate
    }).then(response => buttonTransformer(response.data))
        .catch(err => alert(err));
};

const fetchChartValues = (startDate, endDate, interval) => {
    return requestService.get(resourceUrl + '/visitors/bounce-rate', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[timeFrame]': interval
    }).then(response => response.data.map(chartTransformer))
        .catch(err => alert(err));
};



// const fetchTableValues = (startDate, endDate, groupBy) => {
//     return requestService.get(resourceUrl + '/visitors/by-table', {}, {
//         'filter[start_date]': startDate,
//         'filter[end_date]': endDate,
//         'parameter': groupBy
//     }).then(response => response.data.visitors.map(tableTransformer.bind(null, groupBy)))
//         .catch(err => alert(err));
// };

const averangeSessionService = {
    fetchButtonValue,
    fetchChartValues,
    // fetchTableValues
};

export default averangeSessionService;