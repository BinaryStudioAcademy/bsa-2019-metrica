<template>
    <VFlex
        align-center
        justify-end
        row
        class="pr-2"
    >
        <WebsitesDropdown
            :value="getSelectedWebsite"
            @change="changeWebsite"
        />
        <VBtn
            icon
            class="notifications mr-4"
        >
            <svg>
                <use href="/assets/icons/bell.svg#root" />
            </svg>
        </VBtn>
        <VToolbarTitle class="hidden-sm-and-down username mr-6">
            Hello, <span>{{ user.name }}</span>
        </VToolbarTitle>
        <VAvatar
            width="32"
            height="auto"
        >
            <img src="/assets/images/avatar.png">
        </VAvatar>
        <VMenu
            bottom
            offset-y
        >
            <template v-slot:activator="{ on }">
                <VIcon
                    class="drop-down"
                    v-on="on"
                >
                    arrow_drop_down
                </VIcon>
            </template>
            <VList flat>
                <VListItem 
                    v-for="link in links"
                    :key="link.text"
                >
                    <RouterLink
                        :to="{ name: link.route }"
                    >
                        {{ link.text }}
                    </RouterLink>
                </VListItem>
                <VListItem @click="endSession">
                    Log Out
                </VListItem>
            </VList>
        </VMenu>
    </VFlex>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import {GET_AUTHENTICATED_USER} from "@/store/modules/auth/types/getters";
    import {GET_SELECTED_WEBSITE} from "@/store/modules/website/types/getters";
    import {LOGOUT} from "@/store/modules/auth/types/actions";
    import {RESET_DATA, CHANGE_SELECTED_WEBSITE} from "@/store/modules/website/types/actions";
    import WebsitesDropdown from "../header/WebsitesDropdown.vue";

    export default {
        components: {
            WebsitesDropdown
        },
        data: () => ({
            links: [
                {
                    text: 'Dashboard',
                    route: 'dashboard'
                }
            ],
            bell: {
                icon: '/assets/icons/bell.svg'
            }
        }),
        methods: {
            ...mapActions('auth', {
                logout: LOGOUT
            }),
            ...mapActions('website', {
                resetData: RESET_DATA,
                changeSelectedWebsite: CHANGE_SELECTED_WEBSITE,
            }),
            endSession() {
                this.logout();
                this.resetData();
                this.$router.push({ name: 'home' });
            },
            changeWebsite(data) {
                this.changeSelectedWebsite(data);
            },
        },
        computed: {
            ...mapGetters('auth',  {
                user: GET_AUTHENTICATED_USER,
            }),
            ...mapGetters('website', {
                getSelectedWebsite: GET_SELECTED_WEBSITE,
            }),

        }
    };
</script>

<style scoped lang="scss">
$grey: rgba(18, 39, 55, 0.5);
svg {
    width: 25px;
    height: 25px;
}

svg path {
    fill: inherit;
    fill-opacity: inherit;
}
.v-icon.drop-down {
    color: #3C57DE;
}

.v-list-item.v-list-item--link,
.v-list-item a
{
        font-family: 'Gilroy';
        font-size: 12px;
        color: inherit;
        &:hover {
            
        }
}

a:hover{
    text-decoration: none;
}
</style>