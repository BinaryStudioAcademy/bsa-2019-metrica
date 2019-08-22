import requestService from "@/services/requestService";
import config from "@/config";
import {buttonTransformer, tableTransformer, chartTransformer} from './transformers';
import _ from "lodash";

const resourceUrl = config.getApiUrl();

const fetchButtonValue = (startDate, endDate) => {
    return requestService.get(resourceUrl + '/sessions/average', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate
    }).then(response => buttonTransformer(response.data))
        .catch(error => throw new Error(_.get(error, 'response.data.error.message',
            'Something went wrong with getting average session')));
};

const fetchChartValues = (startDate, endDate, interval) => {
    return requestService.get(resourceUrl + '/visitors/bounce-rate', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[timeFrame]': interval
    }).then(response => response.data.map(chartTransformer))
        .catch(error => throw new Error(_.get(error, 'response.data.error.message',
            'Something went wrong with getting average session')));
};

const fetchTableValues = (startDate, endDate, groupBy) => {
    return requestService.get(resourceUrl + '/table-sessions/avg-session-time', {}, {
        'filter[start_date]': startDate,
        'filter[end_date]': endDate,
        'filter[parameter]': groupBy
    }).then(response => response.data.map(tableTransformer))
        .catch(error => throw new Error(_.get(error, 'response.data.error.message',
            'Something went wrong with getting average session')));
};

const averageSessionService = {
    fetchButtonValue,
    fetchChartValues,
    fetchTableValues
};

export default averageSessionService;