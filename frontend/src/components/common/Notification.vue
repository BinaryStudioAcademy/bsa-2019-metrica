<template>
    <VAlert
        class="notification"
        transition="slide-x-reverse-transition"
        outlined
        :value="active"
        :type="alertType"
        text
    >
        {{ text }}
    </VAlert>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import { SHOW_SUCCESS, SHOW_ERROR } from '@/store/modules/notification/types/actions';
    import {
        GET_TEXT,
        GET_TYPE,
        IS_ACTIVE
    } from '@/store/modules/notification/types/getters';

    export default {
        name: "Notification",

        computed: {
            ...mapGetters('notification', {
                text: GET_TEXT,
                alertType: GET_TYPE,
                active: IS_ACTIVE
            })
        },

        methods: {
            ...mapActions('notification', {
                showSuccessMessage: SHOW_SUCCESS,
                showErrorMessage: SHOW_ERROR
            })
        }
    }
</script>

<style lang="scss" scoped>
    $width: 350px;
    .notification {
        position: fixed;
        width: $width;
        z-index: 10000;
        transition: all .8s ease;
    }
</style>