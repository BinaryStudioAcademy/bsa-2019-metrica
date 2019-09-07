<template>
    <ContentLayout>
        <RouterView />
    </ContentLayout>
</template>

<script>
    import ContentLayout from '../components/layout/ContentLayout.vue';
    import {isWebsite} from '../mixins/isWebsite';

    export default {
        mixins: [isWebsite],
        name: "Behavior",
        components: {
            ContentLayout
        }
    };
</script>

<style scoped>

</style>