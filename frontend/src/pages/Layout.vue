<template>
    <VApp>
        <Header />
        <RouterView />
        <Footer />
        <Notification />
    </VApp>
</template>

<script>
    import Header from '../components/layout/Header.vue';
    import Footer from '../components/layout/Footer.vue';
    import Notification from "@/components/common/Notification";

    export default {
        components: {
            Header,
            Footer,
            Notification
        }
    };
</script>
