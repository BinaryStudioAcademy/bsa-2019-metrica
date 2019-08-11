import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import {authPlugin} from "./plugins";
import website from './modules/website';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        website
    },
    plugins: [authPlugin]
});