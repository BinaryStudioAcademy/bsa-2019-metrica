<template>
    <VContainer>
        <h4>{{ title }}</h4>
        <VImg
            :src="require('@/assets/running_man.jpg')"
            width="50%"
            height="50%"
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

