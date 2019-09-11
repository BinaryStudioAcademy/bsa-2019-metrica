<template>
    <VCardTitle
        primary-title
        class="grey--text"
    >
        There is no data to display!
    </VCardTitle>
</template>

<script>
    export default {
        name: "NoData"
    };
</script>

<style lang="scss" scoped>
    .v-card__title {
        display: flex;
        height: calc(50vh - 1.5rem);
        justify-content: center;
        align-content: center;
        padding: 0;
    }
</style>