<template>
    <Spinner v-if="isLoading" />
    <RouterView v-else />
</template>

<script>
    import {mapActions} from "vuex";
    import {FETCH_CURRENT_WEBSITE} from "@/store/modules/website/types/actions";
    import Spinner from "../utilites/Spinner";

    export default {
        name: 'WebsiteGuard',
        components: {
            Spinner
        },
        data() {
            return {
                isLoading: true
            };
        },
        methods: {
            ...mapActions('website', {
                fetchCurrentWebsite: FETCH_CURRENT_WEBSITE
            })
        },
        created() {
            this.fetchCurrentWebsite().then(() => {
                this.isLoading = false;
            });
        }
    };
</script>