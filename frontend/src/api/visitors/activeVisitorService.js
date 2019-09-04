import requestService from "@/services/requestService";
import config from "@/config";
import _ from "lodash";

const resourceUrl = config.getApiUrl();


const getActivityDataItems = (websiteId) => {
    return requestService.get(resourceUrl + '/visitors/activity-visitors', {}, {
        'filter[website_id]': websiteId,
    }).then(response => response.data)
        .catch(error => Promise.reject(
            new Error(
                _.get(
                    error,
                    'response.data.error.message',
                    'Something went wrong with getting page views'
                )
            )
        ));
};
export {
    getActivityDataItems,
};
