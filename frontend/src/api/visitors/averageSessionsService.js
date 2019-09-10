import requestService from "@/services/requestService";
import config from "@/config";
import {buttonTransformer, tableTransformer, chartTransformerToInt} from '../transformers';
import _ from "lodash";

const resourceUrl = config.getApiUrl();

const fetchButtonValue = (startDate, endDate, websiteId) => {
    return requestService.get(resourceUrl + '/sessions/average', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[website_id]': websiteId,
    }).then(response => buttonTransformer(response.data))
        .catch(error => Promise.reject(
            new Error(
                _.get(
                    error,
                    'response.data.error.message',
                    'Something went wrong with getting average session'
                )
            )
        ));
};

const fetchChartValues = (startDate, endDate, interval, websiteId) => {
    return requestService.get(resourceUrl + '/chart-average-sessions', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[period]': interval,
        'filter[website_id]': websiteId,
    }).then(response => response.data.map(chartTransformerToInt))
        .catch(error => Promise.reject(
            new Error(
                _.get(
                    error,
                    'response.data.error.message',
                    'Something went wrong with getting average session'
                )
            )
        ));
};

const fetchTableValues = (startDate, endDate, groupBy, websiteId) => {
    return requestService.get(resourceUrl + '/table-sessions/avg-session-time', {}, {
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
                    'Something went wrong with getting average session'
                )
            )
        ));
};

export const averageSessionService = {
    fetchButtonValue,
    fetchChartValues,
    fetchTableValues
};
