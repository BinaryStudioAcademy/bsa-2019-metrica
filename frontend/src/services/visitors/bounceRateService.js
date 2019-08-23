import requestService from "../requestService";
import config from "@/config";
import {buttonTransformer, chartTransformer, tableTransformer} from './transformers';

const resourceUrl = config.getApiUrl();

const fetchButtonValue = (startDate, endDate) => {
    return requestService.get(resourceUrl + '/visitors/bounce-rate/total', {}, {
        'filter[start_date]': startDate,
        'filter[end_date]': endDate
    }).then(response => buttonTransformer(response.data))
        .catch(err => throw err);
};

const fetchChartValues = (startDate, endDate, interval) => {
    return requestService.get(resourceUrl + '/visitors/bounce-rate', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[timeFrame]': interval
    }).then(response => response.data.map(chartTransformer))
        .catch(err => throw err);
};

const fetchTableValues = (startDate, endDate, groupBy) => {
    return requestService.get(resourceUrl + '/visitors/by-table', {}, {
        'filter[start_date]': startDate,
        'filter[end_date]': endDate,
        'parameter': groupBy
    }).then(response => response.data.visitors.map(tableTransformer.bind(null, groupBy)))
        .catch(err => throw err);
};

const bounceRateService = {
    fetchButtonValue,
    fetchChartValues,
    fetchTableValues
};

export default bounceRateService;