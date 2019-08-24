import Vue from 'vue';
import Router from 'vue-router';
import Login from '../pages/Login.vue';
import LoginGuard from '@/components/auth/LoginGuard.vue';
import ResetPassword from "../pages/ResetPassword";
import SignUp from "../pages/SignUp.vue";
import Dashboard from '@/pages/Dashboard.vue';
import UserUpdate from '../pages/UpdateProfile.vue';
import AddWebsitePage from '../pages/AddWebsitePage.vue';
import Visitors from "../pages/Visitors.vue";
import Home from "../pages/Home.vue";
import StepAddName from '@/components/website/adding_master/StepAddName.vue';
import StepAddDomain from '@/components/website/adding_master/StepAddDomain.vue';
import StepTrackingInfo from '@/components/website/adding_master/StepTrackingInfo.vue';
import WebsiteInfo from '../pages/WebsiteInfo.vue';
import Default from '@/components/layout/Default.vue';
import UserDataProviderPage from '../pages/UserDataProviderPage.vue';
import WebsiteDataProvider from '../pages/WebsiteDataProvider.vue';
import SocialAuthPage from '@/pages/SocialAuthPage.vue';
import PageViews from "../pages/PageViews.vue";
import Audience from "../pages/Audience.vue";

const originalPush = Router.prototype.push;
Router.prototype.push = function push(location, onResolve, onReject) {
    if (onResolve || onReject) {
        return originalPush.call(this, location, onResolve, onReject);
    }
    return originalPush.call(this, location).catch(() => { });
};

Vue.use(Router);

export default new Router({
    mode: 'history',
    base: '/',
    routes: [
        {
            path:'/',
            component: UserDataProviderPage,
            children: [
                {
                    path: '',
                    redirect: { name: 'home' }
                },
                {
                    path: 'home',
                    name: 'home',
                    component: Home,
                },
                {
                    path: 'login',
                    name: 'login',
                    component: Login,
                    props: true
                },
                {
                    path: 'signup',
                    name: 'signup',
                    component: SignUp,
                },
                {
                    path: 'reset-password',
                    name: 'reset-password',
                    component: ResetPassword,
                },
                {
                    path: '/auth/social/:provider',
                    name: 'social-auth',
                    component: SocialAuthPage
                },
        {
            path: '',
                    component: LoginGuard,
                    children: [
                        {
                            path: '',
                            component: WebsiteDataProvider,
                            children: [
                                {
                                    path: 'dashboard',
                                    name: 'dashboard',
                                    component: Dashboard,
                                    meta: {
                                        title: 'Dashboard'
                                    },
                                },
                                {
                                    path: 'audience',
                                    component: Audience,
                                    children: [
                                        {
                                            path: 'visitors',
                                            name: 'visitors',
                                            component: Visitors,
                                            meta: {
                                                title: 'Visitors'
                                            },
                                        },
                                        {
                                            path: 'page-views',
                                            name: 'page-views',
                                            component: PageViews,
                                            meta: {
                                                title: 'Page views'
                                            },
                                        },
                                        {
                                            path: 'geo-locations',
                                            name: 'geo-locations',
                                            meta: {
                                                title: 'Geo locations'
                                            },
                                        },
                                    ]
                                },
                                {
                                    path: 'user-settings',
                                    name: 'user-update',
                                    component: UserUpdate
                                },
                                {
                                    path: 'settings',
                                    name: 'settings',
                                    component: Visitors
                                },
                                {
                                    path: 'behaviour',
                                    name: 'behaviour',
                                    component: Default,
                                    meta: {
                                        title: 'Behaviour'
                                    },
                                },
                                {
                                    path: 'speedoverview',
                                    name: 'speedoverview',
                                    component: Default,
                                    meta: {
                                        title: 'Speedoverview'
                                    },
                                },
                                {
                                    path: 'website/info',
                                    name: 'websiteinfo',
                                    component: WebsiteInfo
                                },
                                {
                                    path: 'website/add',
                                    component: AddWebsitePage,
                                    children: [
                                        {
                                            path: '',
                                            name: 'add_website',
                                            redirect: { name: 'add_websites_step_1' },
                                        },
                                        {
                                            path: 'step-1',
                                            name: 'add_websites_step_1',
                                            component: StepAddName,
                                            meta: {
                                                step: 1
                                            },
                                            props: true,
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
                                }
                            ]
                        }
                    ]
                }
            ]
        }
    ]
});
