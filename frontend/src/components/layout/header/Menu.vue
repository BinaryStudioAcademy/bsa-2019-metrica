<template>
    <VMenu>
        <template v-slot:activator="{ on }">
            <VIcon
                class="drop-down"
                v-on="on"
            >
                arrow_drop_down
            </VIcon>
        </template>
        <VList>
            <VListItem
                :key="item"
                v-for="item in items"
            >
                <VListItemTitle>
                    {{ item }}
                </VListItemTitle>
            </VListItem>
        </VList>
    </VMenu>
</template>

<script>
    export default {
        data: () => ({
            items: ['profile', 'sign out'],
            bell: {
                icon: '/assets/icons/bell.svg'
            }
        }),
    }
</script>

<style scoped lang="scss">
.v-icon.drop-down {
    color: #3C57DE;
}
</style>