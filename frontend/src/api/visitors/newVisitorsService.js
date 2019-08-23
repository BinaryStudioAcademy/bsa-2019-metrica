import requestService from "@/services/requestService";
import config from "@/config";
import {buttonTransformer, chartTransformer, tableTransformer} from './transformers';
import _ from "lodash";

const resourceUrl = config.getApiUrl();

const fetchButtonValue = (startDate, endDate) => {
    return requestService.get(resourceUrl + '/visitors/new/count', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate
    }).then(response => buttonTransformer(response.data))
        .catch(error => Promise.reject(
            new Error(
                _.get(
                    error,
                    'response.data.error.message',
                    'Something went wrong with getting new visitors'
                )
            )
        ));
};

const fetchChartValues = (startDate, endDate, interval) => {
    return requestService.get(resourceUrl + '/chart-new-visitors', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[period]': interval
    }).then(response => response.data.map(chartTransformer))
        .catch(error => Promise.reject(
            new Error(
                _.get(
                    error,
                    'response.data.error.message',
                    'Something went wrong with getting new visitors'
                )
            )
        ));
};

const fetchTableValues = (startDate, endDate, groupBy) => {
    return requestService.get(resourceUrl + '/visitors/new-visitors-table', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[parameter]': groupBy
    }).then(response => response.data.map(tableTransformer))
        .catch(error => Promise.reject(
            new Error(
                _.get(
                    error,
                    'response.data.error.message',
                    'Something went wrong with getting new visitors'
                )
            )
        ));
};

export const newVisitorsService = {
    fetchButtonValue,
    fetchChartValues,
    fetchTableValues
};

export default newVisitorsService;