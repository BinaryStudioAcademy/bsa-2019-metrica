<template>
    <VListItem
        class="justify-space-between align-center pa-0"
    >
        <VIcon
            :color="item.color"
            size="8"
        >
            mdi-circle
        </VIcon>
        <VListItemTitle
            class="pl-2 grey--text"
        >
            {{ item.title }}
        </VListItemTitle>
        <VListItemSubtitle
            class="grey--text"
        >
            {{ item.percentageDiff }}%
        </VListItemSubtitle>
    </VListItem>
</template>

<script>
    export default {
        name: "LegendItem",
        props: {
            item: {
                type: Object,
                required: true
            }
        }
    };
</script>

<style scoped lang="scss">
.v-list-item {
    text-align: end;
    height: 32px;
    min-height: 20px;
    min-width: 120px;
    .v-list-item__title,
    .v-list-item__subtitle {
        font-size: 12px;
        font-family: 'GilroySemiBold';
    }
}

.v-list-item__title {
    text-align: start;
}
</style>