import Vue from 'vue';
import App from './App.vue';
import vuetify from "./plugins/vuetify";
import router from "./plugins/router";
import store from './store';
import 'material-design-icons-iconfont/dist/material-design-icons.css';

Vue.config.productionTip = false;

new Vue({
    render: h => h(App),
    vuetify,
    router,
    store
}).$mount('#app');
