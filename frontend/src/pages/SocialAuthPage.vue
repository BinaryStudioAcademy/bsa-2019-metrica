<template>
    <Spinner
        v-if="isLoading"
    />
</template>

<script>
    import { mapActions } from 'vuex';
    import { SOCIAL_LOGIN } from "@/store/modules/auth/types/actions";
    import Spinner from "@/components/utilites/Spinner";
    import {SHOW_SUCCESS_MESSAGE, SHOW_ERROR_MESSAGE} from "@/store/modules/notification/types/actions";

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
            }),
            ...mapActions('notification', {
                showSuccessMessage: SHOW_SUCCESS_MESSAGE,
                showErrorMessage: SHOW_ERROR_MESSAGE
            }),
        },
        created() {
            const data = {
                ...(this.$route.query || {}),
                provider: this.$route.params.provider,
            };
            this.socialLogin(data)
                .then(() => {
                    this.showSuccessMessage('Logged in');
                    return this.$router
                        .replace({ name: 'dashboard' })
                        .catch(() => {});
                })
                .catch((error) => {
                    this.showErrorMessage(error);
                    return this.$router.replace({ name: 'login' });
                });
        },
    };
</script>
