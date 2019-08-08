import Vue from 'vue';
import Router from 'vue-router';
import Layout from '../pages/Layout.vue';
import Login from '../pages/Login.vue'
import ResetPassword from "../pages/ResetPassword";

Vue.use(Router);

export default new Router({
    mode: 'history',
    base: '/',
    routes: [
        {
            path: '',
            component: Layout,
            children: [
                {
                    path: 'login',
                    name: 'login',
                    component: Login
                },

                {
                    path: 'reset-password',
                    name: 'reset-password',
                    component: ResetPassword
                }
            ]
        },
    ]
})
;