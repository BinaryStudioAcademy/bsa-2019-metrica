import Vue from 'vue';
import App from './App.vue';
import vuetify from "./plugins/vuetify";
import router from "./plugins/router";
import store from './store';
import 'material-design-icons-iconfont/dist/material-design-icons.css';
import { library } from '@fortawesome/fontawesome-svg-core';
import {
    faFacebookF,
    faGoogle
} from '@fortawesome/free-brands-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(faFacebookF, faGoogle);

Vue.component('FontAwesomeIcon', FontAwesomeIcon);

Vue.config.productionTip = false;

new Vue({
    render: h => h(App),
    vuetify,
    router,
    store,
}).$mount('#app');
