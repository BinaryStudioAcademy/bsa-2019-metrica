import requestService from "@/services/requestService";
import config from "@/config";
import {buttonTransformer, chartTransformer, tableTransformer} from './transformers';

const resourceUrl = config.getApiUrl();

const fetchButtonValue = (startDate, endDate) => {
    return requestService.get(resourceUrl + '/button-page-views/count', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate
    }).then(response => buttonTransformer(response.data))
        .catch(error => throw new Error(error.response.data));
};

const fetchChartValues = (startDate, endDate, interval) => {
    return requestService.get(resourceUrl + '/chart-visits', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[period]': interval
    }).then(response => response.data.map(chartTransformer))
        .catch(error => throw new Error(error.response.data));
};

const fetchTableValues = (startDate, endDate, groupBy) => {
    return requestService.get(resourceUrl + '/visits/by-table', {}, {
        'filter[start_date]': startDate,
        'filter[end_date]': endDate,
        'parameter': groupBy
    }).then(response => response.data.map(tableTransformer))
        .catch(error => throw new Error(error.response.data));
};

const visitsService = {
    fetchButtonValue,
    fetchChartValues,
    fetchTableValues
};

export default visitsService;