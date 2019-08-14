<template>
    <VSnackbar
        class="notification"
        right
        top
        multi-line
        :value="active"
        :color="type"
        :timeout="3000"
        @input="hideMessage"
    >
        <div class="justify-start">
            <VIcon color="white">
                {{ icon }}
            </VIcon>
            <span class="notification-text">
                {{ text }}
            </span>
        </div>
        <VBtn
            dark
            text
            @click="hideMessage"
        >
            ✕
        </VBtn>
    </VSnackbar>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import {
        GET_TEXT,
        GET_TYPE,
        IS_ACTIVE
    } from '@/store/modules/notification/types/getters';
    import { HIDE_MESSAGE } from "@/store/modules/notification/types/actions";

    export default {
        name: "Notification",

        computed: {
            ...mapGetters('notification', {
                text: GET_TEXT,
                type: GET_TYPE,
                active: IS_ACTIVE
            }),
            icon: function () {
                return this.type === 'success' ? 'check' : 'error';
            }
        },
        methods: {
            ...mapActions('notification', {
                hideMessage: HIDE_MESSAGE
            })
        }
    };
</script>

<style lang="scss" scoped>
    .notification {
        transition: all .4s ease;

        .notification-text {
            margin-left: .5rem;
        }
    }
</style>
