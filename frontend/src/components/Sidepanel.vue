<template>
    <VNavigationDrawer
        permanent
        app
        clipped
    >
        <VList
            class="mt-12"
            flat
        >
            <VListItem 
                class="pl-8 my-3"
                v-for="link in links"
                :key="link.text"
                router
                :to="link.route"
            >
                <VLayout flex>
                    <VListItemIcon class="py-0 my-0 mr-7">
                        <svg>
                            <use :href="`${link.icon}#root`" />
                        </svg>
                    </VListItemIcon>
                    <VListItemContent class="py-0">
                        <VListItemTitle>
                            {{ link.text }}
                        </VListItemTitle>
                    </VListItemContent>
                </VLayout>
            </VListItem>
        </VList>
    </VNavigationDrawer>
</template>

<script>
    export default {
        data: () => ({
            links: [
                {
                    icon: '/assets/icons/home.svg',
                    text: 'Home',
                    route: 'login'
                },
                {
                    icon: '/assets/icons/person.svg',
                    text: 'Audience',
                    route: 'audience'
                },
                {
                    icon: '/assets/icons/settings.svg',
                    text: 'Behaviour',
                    route: 'behaviour'
                },
                {
                    icon: '/assets/icons/speed.svg',
                    text: 'Speed Overview',
                    route: 'speedoverview'
                },
                {
                    icon: '/assets/icons/settings.svg',
                    text: 'Settings',
                    route: 'settings'
                },
            ]
        })
    }
</script>

<style scoped lang="scss">
$blue: #3C57DE;

svg {
    width: 25px;
    height: 25px;
}

.v-list-item {
    line-height: 17px;
    min-height: 34px;
    height: 34px;
    font-family: 'Gilroy';
    border-left: 3px solid transparent;
    fill-opacity: 0.5;
    .v-list-item__title {
        color: rgba(18, 39, 55);
        font-size: 14px;
    }
    .v-list-item__icon {
        fill: rgba(18, 39, 55, 0.5);
    }
    &:hover {
        text-decoration: none;
    }
}

.v-list-item--active {
    border-left: 3px solid $blue;
    .v-list-item__title {
        color: $blue;
    }
    .v-list-item__icon {
        fill: $blue;
        fill-opacity: 1;
    }
}
</style>