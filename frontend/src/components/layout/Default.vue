<template>
    <ContentLayout :title="title">
        <VImg
            :src="require('@/assets/running_man.jpg')"
            width="50%"
            height="60%"
        />
    </ContentLayout>
</template>

<script>
    import ContentLayout from './ContentLayout.vue';
    export default {
        components: {ContentLayout},
        name: 'Default',
        computed: {
            title () {
                return this.$route.meta.title;
            }
        }
    };
</script>

