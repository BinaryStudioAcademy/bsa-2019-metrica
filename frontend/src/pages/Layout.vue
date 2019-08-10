<template>
    <VApp>
        <Header :is-logged="isLogged" />
        <Sidepanel v-if="isLogged" />
        <RouterView v-if="isLogged" />
        <LoginForm v-else />
    </VApp>
</template>

<script>
    import {mapGetters} from "vuex";
    import {IS_LOGGED_IN} from "@/store/modules/auth/types/getters";
    import LoginForm from "../components/auth/LoginForm.vue";
    import Header from '../components/Header.vue';
    import Sidepanel from '../components/Sidepanel.vue';

    export default {
        components: {
            Header,
            LoginForm,
            Sidepanel
        },
        computed: {
            ...mapGetters('auth', {
                isLogged: IS_LOGGED_IN
            })
        }
    }
</script>

<style>
@font-face {
    font-family: 'Gilroy';
    src: url('/assets/fonts/Gilroy-Bold.eot');
    src: local('Gilroy Bold'), local('Gilroy-Bold'),
        url('/assets/fonts/Gilroy-Bold.eot?#iefix') format('embedded-opentype'),
        url('/assets/fonts/Gilroy-Bold.woff') format('woff'),
        url('/assets/fonts/Gilroy-Bold.ttf') format('truetype');
}

@font-face {
    font-family: 'GilroyLight';
    src: url('/assets/fonts/Gilroy-Light.eot');
    src: local('Gilroy Light'), local('Gilroy-Light'),
        url('/assets/fonts/Gilroy-Light.eot?#iefix') format('embedded-opentype'),
        url('/assets/fonts/Gilroy-Light.woff') format('woff'),
        url('/assets/fonts/Gilroy-Light.ttf') format('truetype');
}

@font-face {
    font-family: 'Inter';
    font-display: swap;
    src: url("/assets/fonts/Inter-Regular.woff2") format("woff2"),
        url("/assets/fonts/Inter-Regular.woff") format("woff");
}

@font-face {
    font-family: 'InterBold';
    font-display: swap;
    src: url("/assets/fonts/Inter-Bold.woff2") format("woff2"),
        url("/assets/fonts/Inter-Bold.woff") format("woff");
}

svg path {
    fill: inherit;
    fill-opacity: inherit;
}

.v-navigation-drawer__border {
    display: none;
}

.v-toolbar__content {
    border-bottom: 1px solid rgba(0, 0, 0, 0.034);
    height: 61px;
}
</style>
