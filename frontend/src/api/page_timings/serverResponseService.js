import requestService from "@/services/requestService";
import config from "@/config";
import {chartTransformer} from './transformers';
import _ from "lodash";

const resourceUrl = config.getApiUrl();

const chartDataUrl = '/page-timing/chart/server-response';

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
                    'Something went wrong with getting average server response time'
                )
            )
        ));
};

export const serverResponseService = {
    fetchChartValues,
};
