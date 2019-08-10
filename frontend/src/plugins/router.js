import Vue from 'vue';
import Router from 'vue-router';
import Layout from '../pages/Layout.vue';
import Login from '../pages/Login.vue';
import LoginGuard from '../components/auth/LoginGuard.vue';
import SignUp from "../pages/SignUp.vue";
import AddWebsitePage from '../pages/AddWebsitePage.vue';
import Visitors from "../pages/Visitors.vue";
import StepAddName from '@/components/website/adding_master/StepAddName.vue';
import StepAddDomain from '@/components/website/adding_master/StepAddDomain.vue';
import StepTrackingInfo from '@/components/website/adding_master/StepTrackingInfo.vue';

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
                            path: 'websites/add',
                            component: AddWebsitePage,
                            children: [
                                {
                                    path: 'step-1',
                                    name: 'add_websites_step_1',
                                    component: StepAddName,
                                    meta: {
                                        step: 1
                                    },
                                    props: true
                                },
                                {
                                    path: 'step-2',
                                    name: 'add_websites_step_2',
                                    component: StepAddDomain,
                                    meta: {
                                        step: 2
                                    },
                                    props: true
                                },
                                {
                                    path: 'step-3',
                                    name: 'add_websites_step_3',
                                    component: StepTrackingInfo,
                                    meta: {
                                        step: 3
                                    }
                                }
                            ]
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