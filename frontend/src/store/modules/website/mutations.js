import {ADD_WEBSITE, SET_SITE_DOMAIN, SET_SITE_NAME, SET_SITE_SPA} from "./types/mutations";

export default {
    [SET_SITE_NAME]: (state, name) => {
        state.newWebsite.name = name;
    },
    [SET_SITE_DOMAIN]: (state, domain) => {
        state.newWebsite.domain = domain;
    },
    [SET_SITE_SPA]: (state, single_page) => {
        state.newWebsite.single_page = single_page;
    },
    [ADD_WEBSITE]: (state, website) => {
        state.currentWebsite = website;
    },
}