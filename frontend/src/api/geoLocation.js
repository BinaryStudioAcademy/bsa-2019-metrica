import requestService from "@/services/requestService";
import config from "@/config";

const resourceUrl = config.getApiUrl() + '/geo-location-items';

const getGeoLocationItems = (startDate, endDate) => requestService.get(resourceUrl, {}, {
    'filter[startDate]': startDate,
    'filter[endDate]': endDate
});

export {
    getGeoLocationItems
};