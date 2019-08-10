import Vue from 'vue';
import Router from 'vue-router';
import Login from '../pages/Login.vue'
import ResetPassword from "../pages/ResetPassword";
import LoginGuard from '../components/auth/LoginGuard.vue';
import SignUp from "../pages/SignUp.vue";
import Visitors from "../pages/Visitors.vue";
import Home from "../pages/Home.vue";

Vue.use(Router);

export default new Router({
    mode: 'history',
    base: '/',
    routes: [
        {
            path: '',
            redirect: 'home'
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: 'reset-password',
            name: 'reset-password',
            component: ResetPassword
        },
        {
            path: '',
            component: LoginGuard,
            children: [{
                path: '/visitors',
                name: 'visitors',
                component: Visitors
            }]
        },
        {
            path: '/signup',
            name: 'signup',
            component: SignUp
        },
        {
            path: '/home',
            name: 'home',
            component: Home
        }
    ]
});