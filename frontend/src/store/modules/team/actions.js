import {INVITE_USER, FETCH_TEAM_MEMBERS} from './types/actions';
import {SET_IS_FETCHING, RESET_IS_FETCHING, SET_INVITED_USER, SET_TEAM_MEMBERS} from "./types/mutations";
import {inviteUser, getTeamMembers} from '@/api/team';

export default {
    [INVITE_USER]: (context, email) => {
        const id = context.state.currentWebsite.id;

        return inviteUser(email, id)
            .then(response => context.commit(SET_INVITED_USER, response.data))
            .catch(error => {
                throw { message: error.response.data.errors.name };
            });
    },

    [FETCH_TEAM_MEMBERS]: (context) => {
        context.commit(SET_IS_FETCHING);
        const id = context.state.currentWebsite.id;

        return getTeamMembers(id)
            .then(response => context.commit(SET_TEAM_MEMBERS, response.data))
            .finally(() => context.commit(RESET_IS_FETCHING));

    }
};

