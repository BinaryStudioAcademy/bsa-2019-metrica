<template>
    <VApp>
        <Navbar />
        <RouterView />
    </VApp>
</template>

<script>
    import Navbar from '../components/Navbar.vue'

    export default {
        components: {
            Navbar
        }
    }
</script>

<style>
#app {
    max-width: 1200px;
}

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
</style>
