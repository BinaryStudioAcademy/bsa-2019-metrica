import Vue from 'vue';
import Router from 'vue-router';
import Layout from '../pages/Layout.vue';
import Login from '../pages/Login.vue';
import LoginGuard from '../components/auth/LoginGuard.vue';
import SignUp from "../pages/SignUp.vue";
import Visitors from "../pages/Visitors.vue";
import Website from "../pages/Website";

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
                    path: '',
                    component: LoginGuard,
                    children: [
                        {
                            path: 'visitors',
                            name: 'visitors',
                            component: Visitors
                        },
                        {
                            path: 'website',
                            name: 'website',
                            component: Website
                        }
                    ]
                },
                {
                    path: 'signup',
                    name: 'signup',
                    component: SignUp
                },
            ]
        }
    ]
})
;
