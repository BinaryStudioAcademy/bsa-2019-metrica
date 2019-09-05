import {SET_INVITED_USER, SET_IS_FETCHING, RESET_IS_FETCHING, SET_TEAM_MEMBERS} from "./types/mutations";

export default {
    [SET_INVITED_USER]: (state, data) => {
        state.currentTeam.members.push(data);
    },
    [SET_TEAM_MEMBERS]: (state, data) => {
        state.currentTeam.members = data;
    },
    [SET_IS_FETCHING]: (state) => {
        state.isFetching = true;
    },
    [RESET_IS_FETCHING]: (state) => {
        state.isFetching = false;
    }
};
