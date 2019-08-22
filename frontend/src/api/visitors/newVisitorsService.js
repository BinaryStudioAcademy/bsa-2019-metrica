import requestService from "@/services/requestService";
import config from "@/config";
import {buttonTransformer, chartTransformer, tableTransformer} from './transformers';

const resourceUrl = config.getApiUrl();

const fetchButtonValue = (startDate, endDate) => {
    return requestService.get(resourceUrl + '/visitors/new/count', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate
    }).then(response => buttonTransformer(response.data))
        .catch(error => throw new Error(error.response.data));
};

const fetchChartValues = (startDate, endDate, interval) => {
    return requestService.get(resourceUrl + '/chart-new-visitors', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[period]': interval
    }).then(response => response.data.map(chartTransformer))
        .catch(error => throw new Error(error.response.data));
};

const fetchTableValues = (startDate, endDate, groupBy) => {
    return requestService.get(resourceUrl + '/visitors/by-table', {}, {
        'filter[start_date]': startDate,
        'filter[end_date]': endDate,
        'parameter': groupBy
    }).then(response => response.data.visitors.map(tableTransformer.bind(null, groupBy)))
        .catch(error => throw new Error(error.response.data));
};

const newVisitorsService = {
    fetchButtonValue,
    fetchChartValues,
    fetchTableValues
};

export default newVisitorsService;