<template>
    <ContentLayout :title="title" />
</template>
<script>
    import { isWebsite } from "@/mixins/isWebsite";
    import ContentLayout from "@/components/layout/ContentLayout";

    export default {
        name: 'Dashboard',
        components: { ContentLayout },
        mixins: [isWebsite],
        computed: {
            title () {
                return this.$route.meta.title;
            }
        }
    };
</script>