<template>
    <VAppBar
        class="elevation-0 "
        clipped-left
        app
        justify-space-between
    >
        <VToolbarTitle class="pl-4">
            <span class="logo pr-3">
                <RouterLink :to="redirectRoute">M</RouterLink>
            </span>
            <span>Metrica</span>
        </VToolbarTitle>
        <UserControls
            v-if="isLoggedIn"
        />
    </VAppBar>
</template>

<script>
    import {mapGetters} from "vuex";
    import {GET_AUTHENTICATED_USER, IS_LOGGED_IN} from "@/store/modules/auth/types/getters";
    import UserControls from './UserControls.vue';
    export default {
        components: {UserControls},
        computed: {
            ...mapGetters('auth', {
                isLoggedIn: IS_LOGGED_IN,
                user: GET_AUTHENTICATED_USER
            }),
            redirectRoute(){
                return this.isLoggedIn ? {name: 'dashboard'} : {name: 'home'};
            }
        }
    };
</script>

<style scoped lang="scss">
    svg {
        width: 25px;
        height: 25px;
    }

    a:hover {
        text-decoration: none;
    }

    ::v-deep .v-toolbar__content {
        border-bottom: 1px solid rgba(0, 0, 0, 0.034);
        justify-content: space-between;

        .v-toolbar__title {
            font-family: 'GilroyLight';
            color: rgba(18, 39, 55, 0.5);
            font-size: 14px;

            &.username {
                font-family: 'Inter';
                font-size: 12px;
                color: #122737;

                span {
                    font-family: 'InterBold';
                }
            }

            .logo {
                font-family: 'InterBold';
                font-size: 24px;

                a {
                    color: #3C57DE !important;
                }
            }
        }

        .notifications {
            position: relative;
            fill: rgba(0, 0, 0, 0.5);

            &::after {
                top: 13px;
                content: '';
                right: 15px;
                width: 7px;
                height: 7px;
                position: absolute;
                background-color: #3C57DE;
                border-radius: 50%;
            }
        }
    }
</style>
