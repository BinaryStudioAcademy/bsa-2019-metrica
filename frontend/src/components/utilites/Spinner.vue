<template>
    <div class="text-center">
        <VOverlay
            class="position-absolute"
            :value="true"
        >
            <VProgressCircular
                indeterminate
                size="64"
            />
        </VOverlay>
    </div>
</template>

<style scoped lang="scss">
    .v-overlay {
        border-radius: 6px;
    }
</style>
