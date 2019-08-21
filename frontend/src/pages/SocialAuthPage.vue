<template>
    <Spinner
        v-if="isLoading"
    />
</template>

<script>
    import { mapActions } from 'vuex';
    import { SOCIAL_LOGIN } from "@/store/modules/auth/types/actions";
    import Spinner from "@/components/utilites/Spinner";

    export default {
        name: 'SocialAuthPage',
        components: {
            Spinner
        },
        data() {
            return {
                isLoading: true
            };
        },
        methods: {
            ...mapActions('auth', {
                socialLogin: SOCIAL_LOGIN
            })
        },
        created() {
            const data = this.$route.query;
            data.provider = this.$route.params.provider;
            this.socialLogin(data)
                .then(() => this.$router.replace({ name: 'home' }))
                .catch(() => this.$router.replace({ name: 'login' }));
        },
    };
</script>
