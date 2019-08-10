<template>
    <div>
        <Spinner />
        <RouterView v-if="isLogged" />
        <LoginForm v-else />
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import {IS_LOGGED_IN} from "@/store/modules/auth/types/getters";
    import LoginForm from "./LoginForm.vue";
    import Spinner from "./Spinner";

    export default {
        components: {
            LoginForm, Spinner
        },
        computed: {
            ...mapGetters('auth', {
                isLogged: IS_LOGGED_IN,
            })
        },
    }
</script>