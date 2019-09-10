import requestService from "@/services/requestService";
import config from "@/config";
import _ from "lodash";

const resourceUrl = config.getApiUrl() + '/visitors-flow';

const getVisitorsFlow = (filter, parameter) => requestService.get(resourceUrl, {}, {
    'filter': filter,
    'parameter': parameter
})
    .then(response => response.data)
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