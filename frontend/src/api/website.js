import requestService from "@/services/requestService";
import config from "@/config";

const resourceUrl = config.getApiUrl();

const addWebsite = data => requestService.create(resourceUrl + '/websites', data);

export {
    addWebsite
}