<template>
    <VListItem
        class="justify-space-between align-center pa-0"
    >
        <VIcon
            :color="color"
            size="8"
        >
            mdi-circle
        </VIcon>
        <VListItemTitle
            class="pl-2 grey--text"
        >
            {{ title }}
        </VListItemTitle>
        <VListItemSubtitle
            class="grey--text"
        >
            {{ percent }}%
        </VListItemSubtitle>
    </VListItem>
</template>

<script>
    export default {
        name: "LegendItem",
        props: {
            color: {
                type: String,
                required: true
            },
            title: {
                type: String,
                required: true
            },
            percent: {
                type: Number,
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