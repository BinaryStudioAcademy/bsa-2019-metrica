<template>
    <VItemGroup mandatory>
        <VItem
            v-for="button in buttons"
            :key="button.label"
        >
            <ButtonComponent
                :type="button.type"
                :label="button.label"
                @change="changeParameter"
            />
        </VItem>
    </VItemGroup>
</template>

<script>
    import ButtonComponent from "./ButtonComponent";
    import {mapActions} from 'vuex';
    import {CHANGE_SELECTED_PARAMETER} from "@/store/modules/geo_location/types/actions";

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
                        type: 'visitors',
                    },
                    {
                        label: 'Sessions',
                        type: 'sessions'
                    },
                    {
                        label: 'Bounce Rate',
                        type: 'bounce_rate'
                    },
                ]
            };
        },
        methods: {
            ...mapActions('geo_location', {
                changeSelectedParameter: CHANGE_SELECTED_PARAMETER
            }),
            changeParameter(parameter) {
                this.changeSelectedParameter(parameter);
            }
        }
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