<template>
    <div>
        <Sidenav v-if="isLogged" />
        <VContent v-if="isLogged">
            <RouterView />
        </VContent>
        <LoginForm v-else />
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import {IS_LOGGED_IN} from "@/store/modules/auth/types/getters";
    import LoginForm from "./LoginForm.vue";
    import Sidenav from "../layout/Sidepanel.vue";

    export default {
        components: {
            LoginForm,
            Sidenav
        },
        computed: {
            ...mapGetters('auth', {
                isLogged: IS_LOGGED_IN
            })
        }
    }
</script>