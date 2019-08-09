<template>
    <VAppBar class="elevation-0 " clipped-left app>
        <VLayout flex align-center class="pl-4 pr-10">
            <VIcon class="mr-2 hidden-lg-and-up" @click="drawer = !drawer">menu</VIcon>
            <VToolbarTitle><span class="logo pr-3">M</span>Metrica</VToolbarTitle>
            <VSpacer></VSpacer>
            <VBadge right>
                <VBtn icon class="notifications">
                    <svg>
                        <use href="/assets/icons/bell.svg#root"></use>
                    </svg>
                </VBtn>
            </VBadge>
            <VToolbarTitle class="username mr-6 ml-4">Hello, <span>Sofi</span></VToolbarTitle>
            <VAvatar>
                <img src="/assets/images/lady.png" alt="">
            </VAvatar>
            <VMenu>
                <template v-slot:activator="{ on }">
                    <VIcon class="drop-down" v-on="on">arrow_drop_down</VIcon>
                </template>
                <VList>
                    <VListItem :key="item" v-for="item in items">
                        <VListItemTitle>
                            {{item}}
                        </VListItemTitle>
                    </VListItem>
                </VList>
            </VMenu>
        </VLayout>
    </VAppBar>
</template>

<script>
export default {
    drawer: true,
    data: () => ({
        items: ['profile', 'sign out'],
        bell: {
            icon: '/assets/icons/bell.svg'
        }
    }),
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

    .v-toolbar__title.username {
        font-family: 'Inter';
        font-size: 12px;
        color: #122737;
    }

    .v-toolbar__title {
        font-family: 'GilroyLight';
        font-weight: light;
        color: rgba(18, 39, 55, 0.5);
        font-size: 14px;
    }

    .v-toolbar__title span.logo {
        font-family: 'InterBold';
        font-size: 24px;
        color: #3C57DE;
    }

    .v-toolbar__title.username span {
        font-family: 'InterBold';
    }

    .v-icon.drop-down {
        color: #3C57DE;
    }

    .notifications {
        position: relative;
        fill: rgba(0, 0, 0, 0.5);
    }

    .notifications::after {
        top: 13px;
        content: '';
        right: 15px;
        width: 7px;
        height: 7px;
        position: absolute;
        background-color: blue;
        border-radius: 50%;
    }
</style>
