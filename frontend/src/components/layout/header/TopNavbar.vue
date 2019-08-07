<template>
    <p v-if="!isLoggedIn">Not logged</p>
    <p v-else>{{user.name}}
        <v-btn @click="logout">Logout</v-btn>
    </p>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import {GET_AUTHENTICATED_USER, IS_LOGGED_IN} from "@/store/modules/auth/types/getters";
    import {LOGOUT} from "@/store/modules/auth/types/actions";

    export default {
        computed: {
            ...mapGetters('auth', {
                isLoggedIn: IS_LOGGED_IN,
                user: GET_AUTHENTICATED_USER
            })
        },
        methods: {
            ...mapActions('auth', {
                logout: LOGOUT
            })
        }
    }
</script>