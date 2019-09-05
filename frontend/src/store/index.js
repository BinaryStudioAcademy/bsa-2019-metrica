import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import {authPlugin} from "./plugins";
import website from './modules/website';
import notification from './modules/notification';
import visitors from './modules/visitors';
import dashboard from './modules/dashboard';
import page_views from './modules/page_views';
import geo_location from './modules/geo_location';
import devices from './modules/devices';
import visits_density_widget from './modules/visits_density_widget';
import team from './modules/team';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        website,
        notification,
        visitors,
        page_views,
        dashboard,
        geo_location,
        devices,
        visits_density_widget,
        team
    },
    plugins: [authPlugin]
});
