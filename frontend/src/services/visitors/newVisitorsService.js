import requestService from "../requestService";
import config from "@/config";
import {buttonTransformer, chartTransformer} from './transformers';

const resourceUrl = config.getApiUrl();

const fetchButtonValue = (startDate, endDate) => {
    return requestService.get(resourceUrl + '/visitors/new/count', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate
    }).then(response => buttonTransformer(response.data))
        .catch(err => alert(err));
};

const fetchChartValues = (startDate, endDate, interval) => {
    return requestService.get(resourceUrl + '/chart-new-visitors', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[period]': interval
    }).then(response => response.data.map(chartTransformer))
        .catch(err => alert(err));
};

// const fetchTableValues = (startDate, endDate, groupBy) => {
//     return new Promise(resolve => {
//         let fakeRequest = {
//             'filter[start_date]': startDate,
//             'filter[end_date]': endDate,
//             'parameter': groupBy
//         }
//     });
// };

const totalVisitorsService = {
    fetchButtonValue,
    fetchChartValues,
    // fetchTableValues
};

export default totalVisitorsService;