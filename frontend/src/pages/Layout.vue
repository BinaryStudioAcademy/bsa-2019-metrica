<template>
    <VApp>
        <Navbar />
        <RouterView/>
    </VApp>
</template>

<script>
import Navbar from '../components/Navbar.vue'
    // import Header from '../components/layout/Header.vue';
    // import Footer from '../components/layout/Footer.vue';
export default {
    components: {
        // Header, Footer, 
        Navbar
    }
}
</script>
