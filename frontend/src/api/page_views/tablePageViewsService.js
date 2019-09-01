import config from "@/config";
import requestService from "@/services/requestService";
import {tableTransformer} from "./transformers";
import _ from "lodash";

const resourceUrl = config.getApiUrl() + '/table-page-views';

const fetchTableValues = (startDate, endDate) => {
    return requestService.get(resourceUrl, {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate
    })
        .then(response => response.data.map(tableTransformer))
        .catch(error => Promise.reject(
            new Error(
                _.get(
                    error,
                    'response.data.error.message',
                    'Something went wrong with getting page views data'
                )
            )
        ));
};

export {
    fetchTableValues
};