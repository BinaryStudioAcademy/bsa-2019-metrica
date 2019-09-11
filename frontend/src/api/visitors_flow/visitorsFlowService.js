import requestService from "@/services/requestService";
import config from "@/config";
import _ from "lodash";

const resourceUrl = config.getApiUrl() + '/visitors-flow';

const getVisitorsFlow = (filter, level) => requestService.get(resourceUrl, {}, {
    'filter': filter,
    'level': level
})
    .then(response => response.data.visitors_flow)
    .catch(error => Promise.reject(
        new Error(
            _.get(
                error,
                'response.data.error.message',
                'Something went wrong with getting visitors flow data'
            )
        )
    ));

export {
    getVisitorsFlow
};