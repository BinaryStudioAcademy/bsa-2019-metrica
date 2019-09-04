import requestService from "@/services/requestService";
import config from "@/config";
import {chartTransformer} from './transformers';
import _ from "lodash";

const resourceUrl = config.getApiUrl();

const chartDataUrl = '/page-timing/chart/domain-lookup';

const fetchChartValues = (startDate, endDate, interval) => {
    return requestService.get(resourceUrl + chartDataUrl, {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[period]': interval
    }).then(response => response.data.map(chartTransformer))
        .catch(error => Promise.reject(
            new Error(
                _.get(
                    error,
                    'response.data.error.message',
                    'Something went wrong with getting average domain lookup time'
                )
            )
        ));
};

export const domainLookupService = {
    fetchChartValues,
};