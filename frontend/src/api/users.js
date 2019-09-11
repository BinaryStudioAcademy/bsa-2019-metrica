import requestService from "@/services/requestService";
import config from "@/config";

const resourceUrl = config.getApiUrl() + '/users';

const updateUser = params => requestService.update(resourceUrl + '/me', params);
const updatePassword = params => requestService.update(resourceUrl + '/update-password', params);

export {
    updateUser,
    updatePassword
};
