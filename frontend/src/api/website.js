import requestService from "@/services/requestService";
import config from "@/config";

const resourceUrl = config.getApiUrl() + '/websites';

const getCurrentUserWebsite = () => requestService.get(resourceUrl);

const addWebsite = data => requestService.create(resourceUrl, data);

export {
    getCurrentUserWebsite,
    addWebsite
};
