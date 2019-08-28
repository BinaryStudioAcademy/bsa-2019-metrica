import config from "@/config";
import requestService from "../../services/requestService";
import {buttonTransformer, chartTransformer} from "./transformers";
import _ from "lodash";

const resourceUrl = config.getApiUrl();

const fetchButtonValue = (startDate, endDate) => {
    return requestService.get(resourceUrl + '/****************', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
    }).then(response => buttonTransformer(response.data))
        .catch(error => Promise.reject(
            new Error(
                _.get(
                    error,
                    'response.data.error.message',
                    'Something went wrong with getting bounce rate of page views'
                )
            )
        ));
};

const fetchChartValues = (startDate, endDate, interval) => {
    return requestService.get(resourceUrl + '/page-views/bounce-rate', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[period]': interval
    }).then(response => response.data.map(chartTransformer))
        .catch(error => Promise.reject(
            new Error(
                _.get(
                    error,
                    'response.data.error.message',
                    'Something went wrong with getting bounce rate of page views'
                )
            )
        ));
};


export const bounceRateService = {
    fetchButtonValue,
    fetchChartValues
};