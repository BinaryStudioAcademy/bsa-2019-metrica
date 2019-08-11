import Vue from "vue";
import {ADD_WEBSITE, SET_WEBSITE_INFO} from "./types/mutations";

export default {
    [SET_WEBSITE_INFO]: (state, data) => {
        Object.keys(data).map(key => {
            Vue.set(state.newWebsite, key,  data[key]);
        })
    },
    [ADD_WEBSITE]: (state, website) => {
        state.currentWebsite = website;
    },
}