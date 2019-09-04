import requestService from "@/services/requestService";
import {devicesAndSystemsTransformer} from "./transformers";
import config from "@/config";
import _ from "lodash";

const url = config.getApiUrl();

const fetchDevicesAndSystemsData = (startDate, endDate, websiteId) => {
    const params = {
        'filter[startDate]': startDate,
        'filter[endDate]': endDate,
        'filter[website_id]': websiteId,
    };
    return Promise.all([
        requestService.get(url + '/devices/stats', {}, params),
        requestService.get(url + '/os/most-popular', {}, params)]
    )
    .then(([devicesResponse, systemsResponse]) => {
        return devicesAndSystemsTransformer(
            devicesResponse.data, systemsResponse.data
        );
    })
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