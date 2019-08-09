import Vue from 'vue';
import Router from 'vue-router';
import Login from '../pages/Login.vue';
import LoginGuard from '../components/auth/LoginGuard.vue';
import SignUp from "../pages/SignUp.vue";
import Visitors from "../pages/Visitors.vue";

Vue.use(Router);

export default new Router({
    mode: 'history',
    base: '/',
    routes: [{
            path: '',
            name: 'home',
            redirect: '/visitors'
        },
        {
            path: '/login',
            name: 'login',
            component: Login
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
        }
    ]
});