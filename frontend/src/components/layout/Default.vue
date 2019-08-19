<template>
    <VContainer
        class="content-with-padding"
    >
        <h5>{{ title }}</h5>
        <VImg
            :src="require('@/assets/running_man.jpg')"
            width="50%"
            height="60%"
        />
    </VContainer>
</template>

<script>
    export default {
        name: 'Default',
        computed: {
            title () {
                return this.$route.meta.title;
            }
        }
    };
</script>

