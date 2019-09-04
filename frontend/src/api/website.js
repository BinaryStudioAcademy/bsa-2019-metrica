import requestService from "@/services/requestService";
import config from "@/config";

const resourceUrl = config.getApiUrl() + '/websites';

const getCurrentUserWebsite = id => requestService.get(resourceUrl + '/' + id);

const addWebsite = data => requestService.create(resourceUrl, data);

const updateWebsite = (data, id) => requestService.update(resourceUrl + '/' + id, data);

export {
    getCurrentUserWebsite,
    addWebsite,
    updateWebsite
};
