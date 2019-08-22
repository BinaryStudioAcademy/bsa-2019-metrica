<template>
    <ContentLayout>
        <RouterView />
    </ContentLayout>
</template>

<script>
    import ContentLayout from '../components/layout/ContentLayout.vue';

    export default {
        name: 'Audience',
        components: {
            ContentLayout
        }
    };
</script>