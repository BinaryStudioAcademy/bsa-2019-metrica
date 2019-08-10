<template>
    <VAppBar
        class="elevation-0 "
        clipped-left
        app
    >
        <VToolbarTitle class="pl-4">
            <span class="logo pr-3">M</span>Metrica
        </VToolbarTitle>
        <VSpacer />
        <VLayout
            right
            align-center
            justify-end
            row
            class="pr-12"
            v-if="loggedIn"
        >
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
        </VLayout>
        <VLayout 
            v-else
            justify-end
            class="pr-3"
        >
            <a
                class="login-btn"
                href="/login"
            >
                Sign In
            </a>
        </VLayout>
    </VAppBar>
</template>

<script>
    export default {
        props: {'isLogged': Boolean},
        data: function(){
            return {
                items: ['profile', 'sign out'],
                bell: {
                    icon: '/assets/icons/bell.svg'
                },
                loggedIn: this.isLogged
            }
        },
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

.v-toolbar__content {
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

    a.login-btn {
        text-transform: capitalize;
        font-family: 'Gilroy';
        font-size: 14px;
        color: black;
        text-decoration: none;
    }
}
</style>