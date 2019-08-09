<template>
    <nav>
        <Header />
        <Sidepanel />
    </nav>
</template>

<script>
import Header from './Header.vue';
import Sidepanel from './Sidepanel.vue';

export default {
    components: { Header, Sidepanel }
}
</script>

<style scoped lang="scss">
::v-deep .v-navigation-drawer__border {
    display: none;
}

::v-deep .v-toolbar__content {
    border-bottom: 1px solid rgba(0, 0, 0, 0.034);
    height: 61px;
}
</style>