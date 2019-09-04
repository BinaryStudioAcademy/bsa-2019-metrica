import requestService from "@/services/requestService";
import config from "@/config";
import {transformer} from "./transformer";
import _ from "lodash";

const resourceUrl = config.getApiUrl() + '/geo-location-items';

const getGeoLocationItems = (startDate, endDate, websiteId) => requestService.get(resourceUrl, {}, {
    'filter[startDate]': startDate,
    'filter[endDate]': endDate,
    'filter[website_id]': websiteId,
})
    .then(response => response.data.map(transformer))
    .catch(error => Promise.reject(
        new Error(
            _.get(
                error,
                'response.data.error.message',
                'Something went wrong with getting geo location data'
            )
        )
    ));

export {
    getGeoLocationItems
};