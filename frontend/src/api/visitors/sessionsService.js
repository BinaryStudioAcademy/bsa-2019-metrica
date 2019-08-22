import requestService from "@/services/requestService";
import config from "@/config";
import {buttonTransformer, chartTransformer, tableTransformer} from './transformers';
import _ from "lodash";

const resourceUrl = config.getApiUrl();

const fetchButtonValue = (startDate, endDate) => {
    return requestService.get(resourceUrl + '/sessions/count', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate
    }).then(response => buttonTransformer(response.data))
        .catch(error => throw new Error(_.get(error, 'response.data.error.message',
            'Something went wrong with getting sessions')));
};

const fetchChartValues = (startDate, endDate, interval) => {
    return requestService.get(resourceUrl + '/chart-sessions', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[period]': interval
    }).then(response => response.data.map(chartTransformer))
        .catch(error => throw new Error(_.get(error, 'response.data.error.message',
            'Something went wrong with getting new visitors')));
};

const fetchTableValues = (startDate, endDate, groupBy) => {
    return requestService.get(resourceUrl + '/sessions/param', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[parameter]': groupBy
    }).then(response => response.data.map(tableTransformer))
        .catch(error => throw new Error(_.get(error, 'response.data.error.message',
            'Something went wrong with getting new visitors')));
};

const sessionsService = {
    fetchButtonValue,
    fetchChartValues,
    fetchTableValues
};

export default sessionsService;