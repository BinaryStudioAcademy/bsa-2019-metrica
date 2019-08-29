import requestService from "@/services/requestService";
import config from "@/config";
import {devicesAndSystemsTransformer} from "@/api/widgets/transformers";
import _ from "lodash";

const resourceUrl = config.getApiUrl();

const fetchDevicesAndSystemsData = (startDate, endDate) => {
    return requestService.get(resourceUrl + '/widget/devices', {}, {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate
    }).then(response => devicesAndSystemsTransformer(response.data.devices))
        .catch(error => Promise.reject(
            new Error(
                _.get(
                    error,
                    'response.data.error.message',
                    'Something went wrong with getting devices and systems'
                )
            )
        ));
};

export {
    fetchDevicesAndSystemsData
};