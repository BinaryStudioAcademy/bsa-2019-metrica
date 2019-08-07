import Vue from 'vue';
import Router from 'vue-router';
import Layout from '../pages/Layout.vue';
import Login from '../pages/Login.vue'
import SignUpForm from "../components/auth/SignUpForm";

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
                    path: 'signup',
                    name: 'signup',
                    component: SignUp
                }
            ]
        }
    ]
})
;