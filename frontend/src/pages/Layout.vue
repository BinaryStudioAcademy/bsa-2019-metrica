<template>
    <VApp>
        <Header />
        <RouterView />
        <Footer />
    </VApp>
</template>

<script>
    import Header from '../components/layout/Header.vue';
    import Footer from '../components/layout/Footer.vue';

    export default {
        components: {
            Header,
            Footer,
        }
    };
</script>

<style lang="scss">

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

#app {
    background: #F5F8FD;
}

svg path {
    fill: inherit;
    fill-opacity: inherit;
}
</style>
