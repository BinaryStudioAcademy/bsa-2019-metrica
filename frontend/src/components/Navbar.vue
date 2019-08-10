<template>
    <nav>
        <Header />
        <Sidepanel v-if="isLoggedIn" />
    </nav>
</template>

<script>
    import Header from './Header.vue';
    import Sidepanel from './Sidepanel.vue';
    import {mapGetters} from "vuex";
    import {IS_LOGGED_IN} from "@/store/modules/auth/types/getters";

    export default {
        components: { Header, Sidepanel },

        computed: {
            ...mapGetters('auth', {
                isLoggedIn: IS_LOGGED_IN,
            })
        }
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