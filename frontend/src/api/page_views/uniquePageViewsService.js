import config from "@/config";
import requestService from "../../services/requestService";
import {buttonTransformer,chartTransformer} from "../transformers";
import _ from "lodash";

const resourceUrl = config.getApiUrl();

const fetchButtonValue = (startDate, endDate, websiteId) => {
    return requestService.get(resourceUrl + '/button-page-views/unique', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[website_id]': websiteId,
    }).then(response => buttonTransformer(response.data))
        .catch(error => Promise.reject(
            new Error(
                _.get(
                    error,
                    'response.data.error.message',
                    'Something went wrong with getting unique page views'
                )
            )
        ));
};

const fetchChartValues = (startDate, endDate, interval, websiteId) => {
    return requestService.get(resourceUrl + '/chart-visits/unique', {}, {
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
                    'Something went wrong with getting unique page views'
                )
            )
        ));
};

export const uniquePageViewsService = {
    fetchButtonValue,
    fetchChartValues
};