<template>
    <VAppBar
        class="elevation-0 "
        clipped-left
        app
    >
        <VLayout
            flex
            align-center
            class="pl-4 pr-10"
        >
            <VToolbarTitle>
                <span class="logo pr-3">M</span>Metrica
            </VToolbarTitle>
            
            <VSpacer />

            <template v-if="isLoggedIn">
                <VBtn
                    icon
                    class="notifications"
                >
                    <svg>
                        <use href="/assets/icons/bell.svg#root" />
                    </svg>
                </VBtn>
                <VToolbarTitle class="username mr-6 ml-4">
                    Hello, <span>Sofi</span>
                </VToolbarTitle>
                <VAvatar>
                    <img src="/assets/images/lady.png">
                </VAvatar>
                <VMenu>
                    <template v-slot:activator="{ on }">
                        <VIcon
                            class="drop-down"
                            v-on="on"
                        >
                            arrow_drop_down
                        </VIcon>
                    </template>
                    <VList>
                        <VListItem
                            :key="item"
                            v-for="item in items"
                        >
                            <VListItemTitle>
                                {{ item }}
                            </VListItemTitle>
                        </VListItem>
                    </VList>
                </VMenu>
            </template>

            <template v-else >
                <router-link :to="{ name: 'login' }">Sign in</router-link>
            </template>

        </VLayout>
    </VAppBar>
</template>

<script>
    import {mapGetters} from "vuex";
    import {IS_LOGGED_IN} from "@/store/modules/auth/types/getters";

    export default {
        data: () => ({
            items: ['profile', 'sign out'],
            bell: {
                icon: '/assets/icons/bell.svg'
            }
        }),

        computed: {
            ...mapGetters('auth', {
                isLoggedIn: IS_LOGGED_IN,
            })
        }        
    }
</script>

<style scoped lang="scss">
svg {
    width: 25px;
    height: 25px;
}

svg path {
    fill: inherit;
    fill-opacity: inherit;
}

.v-toolbar__title {
    font-family: 'GilroyLight';
    font-weight: light;
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

    span.logo {
        font-family: 'InterBold';
        font-size: 24px;
        color: #3C57DE;
    }
}

.v-icon.drop-down {
    color: #3C57DE;
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
        background-color: blue;
        border-radius: 50%;
    }
}

.v-application a {
    font-family: Gilroy;
    font-size: 14px;
    line-height: 17px;
    letter-spacing: 0.4px;
    color: #000000;
}

</style>