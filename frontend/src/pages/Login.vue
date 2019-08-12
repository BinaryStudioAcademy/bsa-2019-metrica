<template>
    <LoginForm @success="onSuccess" />
</template>

<script>
    import LoginForm from '@/components/auth/LoginForm.vue';

    export default {
        components: {
            LoginForm
        },
        methods: {
            onSuccess() {
                this.$router.push({name: 'visitors'});
            },
        },
    }
</script>