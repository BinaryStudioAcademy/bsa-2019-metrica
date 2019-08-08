<template>
    <RouterView v-if="isLogged"/>
    <LoginForm v-else/>
</template>

<script>
    import {mapGetters} from "vuex";
    import {IS_LOGGED_IN} from "@/store/modules/auth/types/getters";
    import LoginForm from "./LoginForm.vue";

    export default {
        components: {
            LoginForm
        },
        computed: {
            ...mapGetters('auth', {
                isLogged: IS_LOGGED_IN
            })
        }
    }
</script>