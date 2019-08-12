import requestService from "@/services/requestService";
import config from "@/config";

const resourceUrl = config.getApiUrl() + '/users';

const updateUser = params => requestService.update(resourceUrl + '/me', params);

export {
    updateUser
}
