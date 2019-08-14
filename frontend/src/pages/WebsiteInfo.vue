<template>
    <WebsiteForm />
</template>

<script>
    import {mapGetters} from "vuex";
    import {IS_CURRENT_WEBSITE} from "@/store/modules/website/types/getters";
    import WebsiteForm from '@/components/website/WebsiteForm.vue';

    export default {
        components: {
            WebsiteForm
        },
        computed: {
            ...mapGetters('website', {
                isCurrentWebsite: IS_CURRENT_WEBSITE
            }),
        },
        created() {
            if (!this.isCurrentWebsite) {
                this.$router.replace({name: 'add_website'});
            }
        }
    }
</script>
