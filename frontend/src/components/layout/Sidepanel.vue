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
                    :disabled="sublink.disable"
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
    import {mapGetters} from 'vuex';
    import {GET_WEBSITE_DATA} from "@/store/modules/website/types/getters";
    export default {
        components: { MenuItem },
        computed: {
            ...mapGetters('website', {
                getCurrentWebsite: GET_WEBSITE_DATA,
            }),
            links () {
                let menu = {
                    visitors: {
                        text: 'Visitors',
                        route: 'visitors',
                        disable: true,
                    },
                    page_views: {
                        text: 'Page Views',
                        route: 'page-views',
                        disable: true,
                    },
                    geo_location: {
                        text: 'Geo Location',
                        route: 'geo-location',
                        disable: true,
                    },
                    visitors_flow: {
                        text: 'Visitors flow',
                        route: 'visitors-flow',
                        disable: true,
                    },
                    page_timings: {
                        text: 'Page Timings',
                        route: 'page-timings',
                        disable: true,
                    },
                    error_reports: {
                        text: 'Error Reports',
                        route: 'error-reports',
                        disable: true,
                    }
                };

                this.getCurrentWebsite.permitted_menu.split(', ').map(function (item) {
                    switch(item) {
                    case 'visitors':
                        menu.visitors.disable = false;
                        break;
                    case 'page-views':
                        menu.page_views.disable = false;
                        break;
                    case 'geo-location':
                        menu.geo_location.disable = false;
                        break;
                    case 'behaviour':
                        menu.visitors_flow.disable = false;
                        break;
                    case 'page-timings':
                        menu.page_timings.disable = false;
                        break;
                    case 'error-reports':
                        menu.error_reports.disable = false;
                        break;
                    }
                });

                return [
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
                            menu.visitors,
                            menu.page_views,
                            menu.geo_location,
                        ]
                    },
                    {
                        icon: '/assets/icons/settings.svg',
                        text: 'Behaviour',
                        route: 'behaviour',
                        sublinks: [
                            menu.visitors_flow,
                        ]
                    },
                    {
                        icon: '/assets/icons/speed.svg',
                        text: 'Speed Overview',
                        sublinks: [
                            menu.page_timings,
                            menu.error_reports,
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
                                text: 'Team',
                                route: 'team',
                            },
                            {
                                text: 'Website',
                                route: 'websiteinfo',
                            },
                        ]
                    },
                ];
            },
        },
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