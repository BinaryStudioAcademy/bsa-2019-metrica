<template>
    <VApp>
        <Navbar />
        <RouterView/>
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
