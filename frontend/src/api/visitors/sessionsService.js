import requestService from "@/services/requestService";
import config from "@/config";
import {buttonTransformer, chartTransformer, tableTransformer} from './transformers';
import _ from "lodash";

const resourceUrl = config.getApiUrl();

const fetchButtonValue = (startDate, endDate, websiteId) => {
    return requestService.get(resourceUrl + '/sessions/count', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[website_id]': websiteId,
    }).then(response => buttonTransformer(response.data))
        .catch(error => Promise.reject(
            new Error(
                _.get(
                    error,
                    'response.data.error.message',
                    'Something went wrong with getting sessions'
                )
            )
        ));
};

const fetchChartValues = (startDate, endDate, interval, websiteId) => {
    return requestService.get(resourceUrl + '/chart-sessions', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[period]': interval,
        'filter[website_id]': websiteId,
    }).then(response => response.data.map(chartTransformer))
        .catch(error => Promise.reject(
            new Error(
                _.get(
                    error,
                    'response.data.error.message',
                    'Something went wrong with getting sessions'
                )
            )
        ));
};

const fetchTableValues = (startDate, endDate, groupBy, websiteId) => {
    return requestService.get(resourceUrl + '/sessions/param', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[parameter]': groupBy,
        'filter[website_id]': websiteId,
    }).then(response => response.data.map(tableTransformer))
        .catch(error => Promise.reject(
            new Error(
                _.get(
                    error,
                    'response.data.error.message',
                    'Something went wrong with getting sessions'
                )
            )
        ));
};

export const sessionsService = {
    fetchButtonValue,
    fetchChartValues,
    fetchTableValues
};
