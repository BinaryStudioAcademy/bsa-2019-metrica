import {INVITE_USER, FETCH_TEAM_MEMBERS, UPDATE_MENU_ACCESS, DELETE_TEAM_MEMBER} from './types/actions';
import {SET_IS_FETCHING, RESET_IS_FETCHING, SET_TEAM_MEMBERS} from "./types/mutations";
import {inviteUser, getTeamMembers, updateMenuAccess, deleteTeamMember} from '@/api/team';

export default {
    [INVITE_USER]: (context, email) => {
        const id = context.rootState.website.selectedWebsite;

        return inviteUser(email, id)
            .catch(error => {
                throw error.message;
            });
    },

    [FETCH_TEAM_MEMBERS]: (context) => {
        context.commit(SET_IS_FETCHING);
        const id = context.rootState.website.selectedWebsite;

        return getTeamMembers(id)
            .then(response => context.commit(SET_TEAM_MEMBERS, response))
            .finally(() => context.commit(RESET_IS_FETCHING));
    },

    [UPDATE_MENU_ACCESS]: (context, data) => {
        const id = context.rootState.website.selectedWebsite;

        return updateMenuAccess(id, data)
            .then(response => context.commit(SET_TEAM_MEMBERS, response));
    },

    [DELETE_TEAM_MEMBER]: (context, userId) => {

        return deleteTeamMember(userId)
            .catch(error => {
                throw error.message;
            });
    }
};
