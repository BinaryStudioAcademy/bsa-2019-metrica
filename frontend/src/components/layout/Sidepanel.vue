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
                v-model="link.active"
            >
                <template v-slot:activator>
                    <RouterLink
                        :to="{ name: link.route }"
                    >
                        <VListItem>
                            <VListItemIcon>
                                <svg>
                                    <use :href="`${link.icon}#root`" />
                                </svg>
                            </VListItemIcon>
                            <VListItemTitle>
                                {{ link.text }}
                            </VListItemTitle>
                        </VListItem>
                    </RouterLink>
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
    export default {
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
                            route: 'geo-locations',
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
                    route: 'speedoverview'
                },
                {
                    icon: '/assets/icons/settings.svg',
                    text: 'Settings',
                    route: 'settings',
                    active: false,
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
        }),

        watch:{
            $route (to, from) {
                this.links.map(item => {
                    if (item.route === 'settings') {
                        if (this.$route.name === 'websiteinfo' ||
                            this.$route.name === 'add_websites_step_1') {
                            item.active = true;
                        } else {
                            item.active = false;
                        }
                    }
                });
            }
        },

        created() {
            this.links.map(item => {
                if (item.route === 'settings') {
                    if (this.$route.name === 'websiteinfo' ||
                        this.$route.name === 'add_websites_step_1') {
                        item.active = true;
                    } else {
                        item.active = false;
                    }
                }
            });
        }
    };
</script>

<style scoped lang="scss">
$blue: #3C57DE;
$grey: rgba(18, 39, 55, 0.5);
$black: black;

svg {
    width: 25px;
    height: 25px;
}

a {
    &:hover{
        text-decoration: none;
    }
}

.v-list-item {
    min-height: 34px;
    height: 34px;
    border-left: 3px solid transparent;
    fill-opacity: 0.5;
    .v-list-item__title {
        color: $grey;
        font-size: 14px;
    }
    a {
        width: 100%;
    }
    .v-list-item__icon {
        fill: $grey;
        align-self: center;
    }
}

.v-list-item--active
{
    .v-list-item {
        border-left: 3px solid $blue;
        .v-list-item__title {
            color: $blue;
        }
        .v-list-item__icon {
            fill: $blue;
            fill-opacity: 1;
        }
    }
}

::v-deep .v-list-group {
    .v-list-group__header {
        min-height: 34px;
        padding: 0;
    }
    .v-list-group__items {
        font-family: 'GilroySemiBold';
        .router-link-active {
            .v-list-item__title {
                color: $blue;
            }
        }
    }
}
</style>