<template>
    <UserLayout />
</template>

<script>
    import UserLayout from '@/components/layout/UserLayout.vue';
    import store from '../store';
    import {FETCH_CURRENT_WEBSITE} from "@/store/modules/website/types/actions";

    export default {
        name: 'WebsiteDataProvider',
        components: {
            UserLayout
        },
        beforeRouteEnter(to,from,next) {
            if (!store.state.website.isFetchedWebsite && store.state.auth.isLoggedIn) {
                store.dispatch(`website/${FETCH_CURRENT_WEBSITE}`).finally(() => next());
            } else {
                next();
            }
        }
    };
</script>