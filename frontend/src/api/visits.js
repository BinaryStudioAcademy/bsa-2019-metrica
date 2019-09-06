import requestService from "@/services/requestService";
import config from "@/config";
import _ from "lodash";

const resourceUrl = config.getApiUrl() + '/visits';

const getVisitsDensity = (startDate, endDate, websiteId) => requestService.get(resourceUrl + '/density', {}, {
    'filter[startDate]': startDate,
    'filter[endDate]': endDate,
    'filter[website_id]': websiteId
})
    .then(response => response.data)
    .catch(error => Promise.reject(
        new Error(
            _.get(
                error,
                'response.data.error.message',
                'Something went wrong with getting visits data'
            )
        )
    ));


export {
    getVisitsDensity
};
