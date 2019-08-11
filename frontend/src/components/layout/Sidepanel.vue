<template>
    <VNavigationDrawer
        app
        clipped
        floating
    >
        <VList
            class="mt-12"
            flat
        >
            <RouterLink 
                v-for="link in links"
                :key="link.text"
                :to="{ name: link.route }"
            >
                <VListItem class="pl-8 my-3">
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
            </RouterLink>
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
                    route: 'home'
                },
                {
                    icon: '/assets/icons/person.svg',
                    text: 'Audience',
                    route: 'visitors'
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
$grey: rgba(18, 39, 55, 0.5);

svg {
    width: 25px;
    height: 25px;
}

a:hover{
    text-decoration: none;
}

a .v-list-item {
    min-height: 34px;
    height: 34px;
    font-family: 'Gilroy';
    border-left: 3px solid transparent;
    fill-opacity: 0.5;
    .v-list-item__title {
        color: $grey;
        font-size: 14px;
    }
    .v-list-item__icon {
        fill: $grey;
    }
}

.router-link-active {
    .v-list-item {
        border-left: 3px solid $blue;
        .v-list-item__title {
            color: $blue;
        }
        .v-list-item__icon {
            fill: #3C57DE;
            fill-opacity: 1;
        }
    }
}
</style>