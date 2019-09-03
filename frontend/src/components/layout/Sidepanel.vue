<template>
    <VNavigationDrawer
        app
        clipped
        floating
        permanent
        class="pt-11"
    >
        <VList>
            <VListGroup
                v-for="link in links"
                :key="link.text"
                no-action
                append-icon=""
                class="my-4"
            >
                <template 
                    v-if="!link.sublinks"
                    v-slot:activator
                >
                    <RouterLink
                        :to="{ name: link.route }"
                    >
                        <MenuItem
                            :icon="`${link.icon}#root`"
                            :label="link.text"
                        />
                    </RouterLink>
                </template>
                <template 
                    v-else
                    v-slot:activator
                >
                    <MenuItem
                        :icon="`${link.icon}#root`"
                        :label="link.text"
                    />
                </template>
                <VListItem
                    v-for="sublink in link.sublinks"
                    :key="sublink.text"
                >
                    <RouterLink
                        :to="{ name: sublink.route }"
                    >
                        <VListItemContent>
                            <VListItemTitle>
                                {{ sublink.text }}
                            </VListItemTitle>
                        </VListItemContent>
                    </RouterLink>
                </VListItem>
            </VListGroup>
        </VList>
    </VNavigationDrawer>
</template>

<script>
    import MenuItem from './MenuItem.vue';
    export default {
        components: { MenuItem },
        data: () => ({
            links: [
                {
                    icon: '/assets/icons/home.svg',
                    text: 'Home',
                    route: 'dashboard'
                },
                {
                    icon: '/assets/icons/person.svg',
                    text: 'Audience',
                    route: 'visitors',
                    sublinks: [
                        {
                            text: 'Visitors',
                            route: 'visitors',
                        },
                        {
                            text: 'Page Views',
                            route: 'page-views',
                        },
                        {
                            text: 'Geo Location',
                            route: 'geo-location',
                        },
                    ]
                },
                {
                    icon: '/assets/icons/settings.svg',
                    text: 'Behaviour',
                    route: 'behaviour'
                },
                {
                    icon: '/assets/icons/speed.svg',
                    text: 'Speed Overview',
                    route: 'page-timings',
                    sublinks: [
                        {
                            text: 'Page Timings',
                            route: 'page-timings',
                        },
                    ]
                },
                {
                    icon: '/assets/icons/settings.svg',
                    text: 'Settings',
                    route: 'settings',
                    sublinks: [
                        {
                            text: 'User',
                            route: 'user-update',
                        },
                        {
                            text: 'Website',
                            route: 'websiteinfo',
                        },
                    ]
                },
            ]
        })
    };
</script>

<style scoped lang="scss">
$blue: #3C57DE;
$grey: rgba(18, 39, 55, 0.5);

a {
    width: 100%;
    &:hover{
        text-decoration: none;
    }
}

::v-deep .v-list-group {
    .v-list-group__header {
        min-height: 34px;
        padding: 0;
    }
    .v-list-item {
        min-height: 34px;
        height: 34px;
    }
    .v-list-group__items {
        font-family: 'GilroySemiBold';
        padding-left: 23px;
        .v-list-item__title {
        color: $grey;
        font-size: 14px;
        }
        .router-link-active {
            .v-list-item__title {
                color: $blue;
            }
        }
    }
}
</style>