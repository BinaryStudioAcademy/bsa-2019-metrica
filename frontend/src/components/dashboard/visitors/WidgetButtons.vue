<template>
    <VItemGroup mandatory>
        <VItem
            v-for="button in buttons"
            :key="button.label"
            v-slot:default="{ active, toggle }"
        >
            <VBtn
                :ripple="false"
                text
                rounded
                :class="active ? 'cyan white--text active' : 'inactive'"
                @click="toggle"
            >
                {{ button.label }}
            </VBtn>
        </VItem>
    </VItemGroup>
</template>

<script>
    export default {
        name: "WidgetButtons",
        data() {
            return {
                buttons: [
                    { label: 'Visitors' },
                    { label: 'Pages' },
                    { label: 'Bounce Rate' },
                ]
            };
        }
    };
</script>

<style scoped lang="scss">
    .v-item-group {
        .v-btn {
            border-radius: 18px;
            font-size: 12px;
            line-height: 14px;
            text-transform: none;
            padding: 3px 15px;
            height: 100%;
            font-family: 'GilroySemiBold';
            &:not(:last-child) {
                margin-right: 16px;
            }
            &.active {
                border: 1px solid #1BC3DA !important;
            }

            &.inactive {
                border: 1px solid rgba(18, 39, 55, 0.116) !important;
            }
            &:before {
                background-color: transparent;
            }
        }
    }

</style>