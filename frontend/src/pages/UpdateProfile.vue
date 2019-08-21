<template>
    <UpdateProfileForm />
</template>

<script>
    import UpdateProfileForm from '../components/auth/UpdateProfileForm.vue';
    import {isWebsite} from '../mixins/isWebsite';

    export default {
        mixins: [isWebsite],
        components: {
            UpdateProfileForm
        }
    };
</script>