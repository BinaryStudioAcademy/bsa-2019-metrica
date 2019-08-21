<template>
    <VContainer class="content-container">
        <h5>{{ title }}</h5>
        <VImg
            :src="require('@/assets/running_man.jpg')"
            width="50%"
            height="50%"
        />
    </VContainer>
</template>

<script>
    import {isWebsite} from '../../mixins/isWebsite';

    export default {
        name: 'Default',
        mixins: [isWebsite],
        computed: {
            title () {
                return this.$route.meta.title;
            }
        }
    };
</script>

<style scoped>
    .content-container {
        padding: 70px 66px 0 80px;
    }
</style>

