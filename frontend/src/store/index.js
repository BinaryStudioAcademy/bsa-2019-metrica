import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import {authPlugin} from "./plugins";
import website from './modules/website';
import notification from './modules/notification';
import visitors from './modules/visitors';
import dashboard from './modules/dashboard';
import page_views from './modules/page_views';
import page_timings from './modules/page_timings';
import geo_location from './modules/geo_location';
import devices from './modules/devices';
import error_report from './modules/error_report';
import visits_density_widget from './modules/visits_density_widget';
import team from './modules/team';
import visitors_flow from './modules/visitors_flow';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        website,
        notification,
        visitors,
        page_views,
        page_timings,
        dashboard,
        geo_location,
        devices,
        visits_density_widget,
        team,
        error_report,
        visitors_flow
    },
    plugins: [authPlugin]
});
