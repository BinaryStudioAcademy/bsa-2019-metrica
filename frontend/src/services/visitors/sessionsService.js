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
    return requestService.get(resourceUrl + '/chart-sessions', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[period]': interval
    }).then(response => response.data.map(chartTransformer))
        .catch(err => alert(err));
};

// const fetchTableValues = (startDate, endDate, groupBy) => {
//     return requestService.get(resourceUrl + '/table-sessions/avg-session-time', {}, {
//         'filter[start_date]': startDate,
//         'filter[end_date]': endDate,
//         'filter[parameter]': groupBy
//     }).then(response => response.data.map(tableTransformer))
//         .catch(err => alert(err));
// };

const sessionsService = {
    fetchButtonValue,
    fetchChartValues,
    // fetchTableValues
};

export default sessionsService;