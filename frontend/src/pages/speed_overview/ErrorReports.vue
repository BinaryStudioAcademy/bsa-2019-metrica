<template>
    <ContentLayout :title="title" />
</template>

<script>
    import ContentLayout from '../../components/layout/ContentLayout.vue';
    import { isWebsite } from "@/mixins/isWebsite";

    export default {
        name: "ErrorReports",
        components: {
            ContentLayout,
        },
        mixins: [isWebsite],
        data() {
            return {
                title: "Error Reports",
            };
        },
    };
</script>

<style scoped>

</style>
