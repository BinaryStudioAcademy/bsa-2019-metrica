import requestService from "@/services/requestService";
import config from "@/config";
import _ from "lodash";

const resourceUrl = config.getApiUrl() + '/websites';

const addWebsite = data => requestService.create(resourceUrl, data);

const updateWebsite = (data, id) => requestService.update(resourceUrl + '/' + id, data);

const getRelateUserWebsites = () => requestService.get(resourceUrl)
    .then(response => response.data)
    .catch(error => Promise.reject(
        new Error(
            _.get(
                error,
                'response.data.error.message',
                'Something went wrong with getting relate websites data'
            )
        )
    ));

export {
    addWebsite,
    updateWebsite,
    getRelateUserWebsites
};
