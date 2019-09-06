import {GET_CURRENT_TEAM} from "./types/getters";

export default {
    [GET_CURRENT_TEAM]: (state) => state.currentTeam.members,
};
