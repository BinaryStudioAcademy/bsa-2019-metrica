<template>
    <p v-if="!isLoggedIn">Not logged</p>
    <p v-else>{{user.name}} <v-btn @click="logout">Logout</v-btn></p>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";

    export default {
        computed: {
            ...mapGetters({
                isLoggedIn: 'auth/isLoggedIn',
                user: 'auth/getAuthenticatedUser'
            })
        },
        methods: {
            ...mapActions({
                logout: 'auth/logout'
            })
        }
    }
</script>