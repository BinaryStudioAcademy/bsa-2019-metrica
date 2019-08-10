import Vue from "vue";
import {ADD_WEBSITE, SET_WEBSITE_INFO} from "./types/mutations";

export default {
    [SET_WEBSITE_INFO]: (state, data) => {
        Vue.set(state.newWebsite, data);
    },
    [ADD_WEBSITE]: (state, website) => {
        state.currentWebsite = website;
    },
}