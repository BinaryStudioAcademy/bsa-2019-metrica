<template>
    <p v-if="!isLoggedIn">Not logged</p>
    <p v-else>{{user.name}}</p>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        computed: {
            ...mapGetters({
                isLoggedIn: 'auth/isLoggedIn',
                user: 'auth/getAuthenticatedUser'
            })
        }
    }
</script>