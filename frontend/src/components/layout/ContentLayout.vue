<template>
    <VContainer
        class="content-with-padding"
    >
        <h5
            v-if="title"
        >
            {{ title }}
        </h5>
        <slot />
    </VContainer>
</template>

<script>
    export default {
        name: 'ContentLayout',
        props: {
            title: {
                type: [Number, String],
                required: false,
                default: ''
            }
        }
    };
</script>

<style scoped lang="scss">
    h5 {
        margin-bottom: 20px;
    }
    .content-with-padding {
        width: 90%;
        margin: 0 auto;
        padding: 32px 0;
    }
</style>
