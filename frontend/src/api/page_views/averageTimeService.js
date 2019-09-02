import config from "@/config";
import requestService from "../../services/requestService";
import {buttonTransformerToTime,chartTransformer} from "./transformers";
import _ from "lodash";

const resourceUrl = config.getApiUrl();

const fetchButtonValue = (startDate, endDate) => {
    return requestService.get(resourceUrl + '/button-page-views/avg-time', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
    }).then(response => buttonTransformerToTime(response.data))
        .catch(error => Promise.reject(
            new Error(
                _.get(
                    error,
                    'response.data.error.message',
                    'Something went wrong with getting average time page views'
                )
            )
        ));
};

const fetchChartValues = (startDate, endDate, interval) => {
    return requestService.get(resourceUrl + '/chart-page-views/avg-time', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[period]': interval
    }).then(response => response.data.map(chartTransformer))
        .catch(error => Promise.reject(
            new Error(
                _.get(
                    error,
                    'response.data.error.message',
                    'Something went wrong with getting average time page views'
                )
            )
        ));
};

export const averageTimeService = {
    fetchButtonValue,
    fetchChartValues
};