<template>
    <RouterView />
</template>

<script>
    import store from '../store';
    import {FETCH_CURRENT_USER} from "@/store/modules/auth/types/actions";

    export default {
        beforeRouteEnter(to,from,next) {
            store.dispatch(`auth/${FETCH_CURRENT_USER}`).finally(() => next());
        }
    };
</script>