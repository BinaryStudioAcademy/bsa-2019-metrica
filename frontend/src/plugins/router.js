import Vue from 'vue';
import Router from 'vue-router';
import Login from '../pages/Login.vue'
import ResetPassword from "../pages/ResetPassword";
import SignUp from "../pages/SignUp.vue";
import Visitors from "../pages/Visitors.vue";
import Layout from '../pages/Layout.vue'

Vue.use(Router);

export default new Router({
    mode: 'history',
    base: '/',
    component: Layout,
    routes: [
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/reset-password',
            name: 'reset-password',
            component: ResetPassword
        },
        {
            path: '/signup',
            name: 'signup',
            component: SignUp
        },
        {
            path: '/visitors',
            name: 'visitors',
            component: Visitors
        },
    ]
});