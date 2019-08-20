<template>
    <UserLayout v-if="isLogged" />
    <LoginForm v-else />
</template>

<script>
    import {mapGetters} from "vuex";
    import {IS_LOGGED_IN} from "@/store/modules/auth/types/getters";
    import LoginForm from "./LoginForm.vue";
    import UserLayout from "@/components/layout/UserLayout.vue";

    export default {
        components: {
            LoginForm,
            UserLayout
        },
        computed: {
            ...mapGetters('auth', {
                isLogged: IS_LOGGED_IN,
            })
        }
    };
</script>