<template>
    <UserLayout v-if="isLogged" />
    <Login v-else />
</template>

<script>
    import {mapGetters} from "vuex";
    import {IS_LOGGED_IN} from "@/store/modules/auth/types/getters";
    import Login from "../../pages/Login.vue";
    import UserLayout from "@/components/layout/UserLayout.vue";

    export default {
        components: {
            Login,
            UserLayout
        },
        data() {
            return {};
        },
        computed: {
            ...mapGetters('auth', {
                isLogged: IS_LOGGED_IN,
            })
        }
    };
</script>