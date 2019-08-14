import requestService from "@/services/requestService";
import config from "@/config";

const resourceUrl = config.getApiUrl() + '/websites';

const getCurrentUserWebsite = () => requestService.get(resourceUrl + '/');

const addWebsite = data => requestService.post(resourceUrl + '/', data);

export {
    getCurrentUserWebsite,
    addWebsite
};