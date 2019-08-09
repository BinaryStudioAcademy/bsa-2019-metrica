import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import website from './modules/website';
import {authPlugin} from "./plugins";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        website
    },
    plugins: [authPlugin]
});
