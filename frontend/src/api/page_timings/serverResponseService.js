import requestService from "@/services/requestService";
import config from "@/config";
import {buttonTransformerToSeconds, chartTransformerToSeconds, tableTransformerPageTiming} from '../transformers';
import _ from "lodash";

const resourceUrl = config.getApiUrl();

const chartDataUrl = '/page-timing/chart/server-response';
const btnDataUrl = '/page-timing/button/server-response';
const tableDataUrl = '/page-timing/table/server-response';
const errorMessage = 'Something went wrong with getting average server response time';

const fetchButtonValue = (startDate, endDate, websiteId) => {
    return requestService.get(resourceUrl + btnDataUrl, {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[website_id]': websiteId
    }).then(response => buttonTransformerToSeconds(response.data))
        .catch(error => Promise.reject(
            new Error(
                _.get(
                    error,
                    'response.data.error.message',
                    errorMessage
                )
            )
        ));
};

const fetchChartValues = (startDate, endDate, interval, websiteId) => {
    return requestService.get(resourceUrl + chartDataUrl, {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[period]': interval,
        'filter[website_id]': websiteId
    }).then(response => response.data.map(chartTransformerToSeconds))
        .catch(error => Promise.reject(
            new Error(
                _.get(
                    error,
                    'response.data.error.message',
                    errorMessage
                )
            )
        ));
};

const fetchTableValues = (startDate, endDate, parameter) => {
    return requestService.get(resourceUrl + tableDataUrl, {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[parameter]': parameter
    }).then(response => response.data.map(tableTransformerPageTiming))
        .catch(error => Promise.reject(
            new Error(
                _.get(
                    error,
                    'response.data.error.message',
                    errorMessage
                )
            )
        ));
};

export const serverResponseService = {
    fetchChartValues,
    fetchButtonValue,
    fetchTableValues
};
