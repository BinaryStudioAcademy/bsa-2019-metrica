<template>
    <ContentLayout :title="title">
        <Overview />
    </ContentLayout>
</template>
<script>
    import { isWebsite } from "@/mixins/isWebsite";
    import ContentLayout from "@/components/layout/ContentLayout";
    import Overview from "@/components/dashboard/dashboard/Overview";
    export default {
        name: 'Dashboard',
        components: { ContentLayout, Overview },
        mixins: [isWebsite],
        computed: {
            title () {
                return this.$route.meta.title;
            }
        }
    };
</script>