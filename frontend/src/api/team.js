import requestService from "@/services/requestService";
import config from "@/config";
import _ from "lodash";

const resourceUrl = config.getApiUrl() + '/teams';

const getTeamMembers = websiteId => requestService.get(resourceUrl, {}, {
    'website_id': websiteId,
})
    .then(response => response.data)
    .catch(error => Promise.reject(
        new Error(
            _.get(
                error,
                'response.data.error.message',
                'Something went wrong with getting team members data'
            )
        )
    ));

const inviteUser = (email, websiteId) => requestService.create(resourceUrl, {
    'filter': {
        'email': email,
        'website_id': websiteId
    }
});

const updateMenuAccess = (websiteId, data) => requestService.update(resourceUrl + '/menu-access', {
    'filter': {
        'user_ids': data.ids,
        'permitted_menu': data.permitted_menu,
        'website_id': websiteId
    }
});

export {
    getTeamMembers,
    inviteUser,
    updateMenuAccess
};
