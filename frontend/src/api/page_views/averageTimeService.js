import config from "@/config";
import requestService from "../../services/requestService";
import {buttonTransformerToTime, chartTransformerToInt} from "../transformers";
import _ from "lodash";

const resourceUrl = config.getApiUrl();

const fetchButtonValue = (startDate, endDate, websiteId) => {
    return requestService.get(resourceUrl + '/button-page-views/avg-time', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[website_id]': websiteId,
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

const fetchChartValues = (startDate, endDate, interval, websiteId) => {
    return requestService.get(resourceUrl + '/chart-page-views/avg-time', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[period]': interval
    }).then(response => response.data.map(chartTransformerToInt))
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
