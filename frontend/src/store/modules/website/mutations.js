import {
    UPDATE_CURRENT_WEBSITE,
    SET_CURRENT_WEBSITE,
    SET_WEBSITE_INFO,
    RESET_CURRENT_WEBSITES,
    SET_FETCH_TRUE,
    RESET_WEBSITES_DATA,
    SET_SELECTED_WEBSITE,
    RESET_FETCH_WEBSITES,
    SET_RELATE_WEBSITES,
} from "./types/mutations";

export default {
    [SET_WEBSITE_INFO]: (state, data) => {
        state.newWebsite = {
            ...state.newWebsite,
            ...data,
        };
    },
    [SET_CURRENT_WEBSITE]: (state) => {
        state.isCurrentWebsite = true;
    },
    [UPDATE_CURRENT_WEBSITE]: (state, website) => {
        state.currentWebsite = {
            ...state.currentWebsite,
            ...website
        };
    },
    [RESET_CURRENT_WEBSITES]: (state) => {
        state.relateUserWebsites = [];
        state.selectedWebsite = {};
        state.isCurrentWebsite = false;
    },
    [SET_FETCH_TRUE]: (state) => {
        state.isFetchedWebsite = true;
    },
    [RESET_WEBSITES_DATA]: (state) => {
        state.newWebsite = {
            name: '',
            domain: '',
            single_page: false,
        };
        state.relateUserWebsites = [];
        state.selectedWebsite = undefined;
        state.isCurrentWebsite = false;
        state.isFetchedWebsite = false;
    },
    [SET_SELECTED_WEBSITE]: (state, id) => {
        state.selectedWebsite = id;
    },
    [RESET_FETCH_WEBSITES]: (state) => {
        state.isFetchedWebsite = false;
    },
    [SET_RELATE_WEBSITES]: (state, data) => {
        state.relateUserWebsites = data;
    },
};
