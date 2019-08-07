import Vue from 'vue';
import Router from 'vue-router';
import Layout from '../pages/Layout.vue';
import Login from '../pages/Login.vue'
import guards from './guards';
import store from '../store';

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
                ...guard(guards.guest(store))([
                    {
                        path: 'login',
                        name: 'login',
                        component: Login
                    }
                ]),

                ...guard(guards.auth(store))([])
            ]
        }
    ]
})
;