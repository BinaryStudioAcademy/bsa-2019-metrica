import Vue from 'vue';
import Router from 'vue-router';
import Layout from '../pages/Layout.vue';
import Login from '../pages/Login.vue';
import LoginGuard from '../components/auth/LoginGuard.vue';


Vue.use(Router);

const guard = handler => (
    routes => routes.map(route => Object.assign({}, route, {beforeEnter: handler}))
);

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
                    path: "*",
                    name: "guard",
                    component: LoginGuard,
                    children: []
                }
            ]
        }
    ]
})
;