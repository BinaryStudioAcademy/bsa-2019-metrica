import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import {authPlugin} from "./plugins";
import website from './modules/website';
import notification from './modules/notification';
import visitors from './modules/visitors';
import page_views from './modules/page_views';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        website,
        notification,
        visitors,
        page_views
    },
    plugins: [authPlugin]
});
