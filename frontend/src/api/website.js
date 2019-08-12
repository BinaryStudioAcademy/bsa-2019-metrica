import requestService from "@/services/requestService";
import config from "@/config";

const resourceUrl = config.getApiUrl() + '/websites';

const getCurrentUserWebsite = () => requestService.get(resourceUrl + '/');

export {
    getCurrentUserWebsite
}