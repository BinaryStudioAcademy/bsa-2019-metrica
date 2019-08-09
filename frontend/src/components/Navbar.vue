<template>
    <Nav>
        <Header />
        <Sidepanel />
    </Nav>
</template>

<script>
import Header from './Header.vue';
import Sidepanel from './Sidepanel.vue';
    export default {
        components: { Header, Sidepanel },
        data: () => ({
            drawer: true
        })
    }
</script>

<style lang="scss">
    .v-navigation-drawer__border {
        display: none;
    }

    .v-toolbar__content {
        border-bottom: 1px solid rgba(0, 0, 0, 0.034);
        height: 61px;
    }
</style>