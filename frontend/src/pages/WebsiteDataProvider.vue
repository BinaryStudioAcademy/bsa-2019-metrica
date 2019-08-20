<template>
    <RouterView />
</template>

<script>
    import store from '../store';
    import {FETCH_CURRENT_WEBSITE} from "@/store/modules/website/types/actions";

    export default {
        name: 'WebsiteDataProvider',
        beforeRouteEnter(to,from,next) {
            if(!store.state.website.isCurrentWebsite) {
                store.dispatch(`website/${FETCH_CURRENT_WEBSITE}`).finally(() => next());
            } else {
                next();
            }
        }
    };
</script>