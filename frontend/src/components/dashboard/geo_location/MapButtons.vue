<template>
    <VItemGroup mandatory>
        <VItem
            v-for="button in buttons"
            :key="button.label"
        >
            <ButtonComponent
                :type="button.type"
                :label="button.label"
            />
        </VItem>
    </VItemGroup>
</template>

<script>
    import ButtonComponent from "./ButtonComponent";

    export default {
        name: "MapButtons",
        components: {
            ButtonComponent
        },
        data() {
            return {
                buttons: [
                    {
                        label: 'Visitors',
                        type: 'all_visitors_count',
                    },
                    {
                        label: 'Sessions',
                        type: 'sessions_count'
                    },
                    {
                        label: 'Bounce Rate',
                        type: 'bounce_rate'
                    },
                ]
            };
        },
    };
</script>

<style scoped lang="scss">
    .v-item-group {
        button:focus {
            outline: none;
        }
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