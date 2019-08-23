<template>
    <ResetPasswordForm />
</template>

<script>
    import ResetPasswordForm from "../components/auth/ResetPasswordForm";
    import {isCurrentUser} from '../mixins/isCurrentUser';

    export default {
        name: "ResetPassword",
        mixins: [isCurrentUser],
        components: {
            ResetPasswordForm
        }
    };
</script>

<style scoped>

</style>