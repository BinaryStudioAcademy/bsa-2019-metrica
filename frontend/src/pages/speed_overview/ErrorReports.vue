<template>
    <ContentLayout :title="title" />
</template>

<script>
    import ContentLayout from '../../components/layout/ContentLayout.vue';
    export default {
        name: "ErrorReports",
        components: {
            ContentLayout,
        },
        data() {
            return {
                title: "Error Reports",
            };
        },
    };
</script>

<style scoped>

</style>
