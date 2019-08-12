<template>
    <div>
        <Sidenav />
        <VContent>
            <RouterView />
        </VContent>
    </div>
</template>

<script>
    import Sidenav from './Sidepanel.vue';

    export default {
        components: {
            Sidenav
        }
    }
</script>