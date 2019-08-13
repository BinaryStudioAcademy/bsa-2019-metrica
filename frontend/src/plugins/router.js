import Vue from 'vue';
import Router from 'vue-router';
import Login from '../pages/Login.vue'
import LoginGuard from '@/components/auth/LoginGuard.vue';
import ResetPassword from "../pages/ResetPassword";
import SignUp from "../pages/SignUp.vue";
import UserUpdate from '../pages/UpdateProfile.vue';
import AddWebsitePage from '../pages/AddWebsitePage.vue';
import Visitors from "../pages/Visitors.vue";
import Home from "../pages/Home.vue";
import StepAddName from '@/components/website/adding_master/StepAddName.vue';
import StepAddDomain from '@/components/website/adding_master/StepAddDomain.vue';
import StepTrackingInfo from '@/components/website/adding_master/StepTrackingInfo.vue';
import WebsiteInfo from '../pages/WebsiteInfo.vue';

Vue.use(Router);

export default new Router({
    mode: 'history',
    base: '/',
    routes: [
        {
            path: '',
            redirect: { name: 'home' }
        },
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
            path: '',
            component: LoginGuard,
            children: [
                {
                    path: 'dashboard',
                    name: 'dashboard',
                    component: Visitors
                },
                {
                    path: 'visitors',
                    name: 'visitors',
                    component: Visitors
                },
                {
<<<<<<< HEAD
                    path: '/user-settings',
                    name: 'user-update',
                    component: UserUpdate
=======
                    path: 'settings',
                    name: 'settings',
                    component: Visitors
                },
                {
                    path: 'behaviour',
                    name: 'behaviour',
                    component: Visitors
                },
                {
                    path: 'speedoverview',
                    name: 'speedoverview',
                    component: Visitors
                },
                {
                    path: 'website-info',
                    name: 'websiteinfo',
                    component: WebsiteInfo
>>>>>>> e79ec3e8eb880566de813b332b7bcefac92ee19c
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
                },
            ]
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
