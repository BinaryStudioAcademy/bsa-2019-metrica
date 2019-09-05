import requestService from "@/services/requestService";
import config from "@/config";

const resourceUrl = config.getApiUrl() + '/teams';

const getTeamMembers = websiteId => requestService.get(resourceUrl, websiteId);

const inviteUser = (email, websiteId) => requestService.create(resourceUrl, {}, {email, websiteId});

export {
    getTeamMembers,
    inviteUser,
};
