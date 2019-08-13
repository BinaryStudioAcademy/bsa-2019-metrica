<template>
    <Spinner v-if="isLoading" />
    <UserLayout v-else-if="isLogged" />
    <LoginForm v-else />
</template>

<script>
    import {mapGetters, mapActions} from "vuex";
    import {IS_LOGGED_IN} from "@/store/modules/auth/types/getters";
    import LoginForm from "./LoginForm.vue";
    import UserLayout from "@/components/layout/UserLayout.vue";
    import Spinner from "../utilites/Spinner";
    import {FETCH_CURRENT_USER} from "@/store/modules/auth/types/actions";

    export default {
        components: {
            LoginForm,
            UserLayout,
            Spinner
        },
        data() {
            return {
                isLoading: true
            }
        },
        computed: {
            ...mapGetters('auth', {
                isLogged: IS_LOGGED_IN,
            })
        },
        methods: {
            ...mapActions('auth', {
                fetchUserInfo: FETCH_CURRENT_USER
            })
        },
        mounted() {
            this.fetchUserInfo().then(() => {
                this.isLoading = false;
            });
        }
    }
</script>