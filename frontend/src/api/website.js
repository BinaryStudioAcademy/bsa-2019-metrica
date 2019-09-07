import requestService from "@/services/requestService";
import {relateWebsites} from "./transformers";
import config from "@/config";
import _ from "lodash";

const resourceUrl = config.getApiUrl() + '/websites';

const getCurrentUserWebsite = id => requestService.get(resourceUrl + '/' + id);

const addWebsite = data => requestService.create(resourceUrl, data);

const updateWebsite = (data, id) => requestService.update(resourceUrl + '/' + id, data);

const getRelateUserWebsites = () => requestService.get(resourceUrl + '/me/all')
    .then(response => response.data.map(relateWebsites))
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
    getCurrentUserWebsite,
    addWebsite,
    updateWebsite,
    getRelateUserWebsites
};
