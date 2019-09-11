import requestService from "@/services/requestService";
import config from "@/config";
import _ from "lodash";
import {chartTransformer, tableTransformerErrors} from "../transformers";

const resourceUrl = config.getApiUrl() + '/errors';

const getErrorTableItems = (startDate, endDate, parameter) => {
    return requestService.get(resourceUrl + '/table-items', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[parameter]': parameter
    }).then(response => response.data.map(tableTransformerErrors))
        .catch(error => Promise.reject(
            new Error(
                _.get(
                    error,
                    'response.data.error.message',
                    'Something went wrong with getting errors table data'
                )
            )
        ));
};

const getChartValues = (startDate, endDate, interval) => {
    return requestService.get(resourceUrl + '/count', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[period]': interval
    }).then(response => response.data.map(chartTransformer))
        .catch(error => Promise.reject(
            new Error(
                _.get(
                    error,
                    'response.data.error.message',
                    'Something went wrong with getting errors chart data'
                )
            )
        ));
};

export {
    getErrorTableItems,
    getChartValues
};