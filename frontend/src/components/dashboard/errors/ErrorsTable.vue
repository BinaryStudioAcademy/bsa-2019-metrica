<template>
    <VContainer
        p-0
        class="errors-table"
    >
        <VRow
            class="header my-3"
            fluid
        >
            <VCol>
                Page
            </VCol>
            <VCol>
                Message
            </VCol>
            <VCol>
                Count
            </VCol>
            <VCol>
                Details
            </VCol>
        </VRow>
        <VContainer pa-0>
            <VDataTable
                class="caption"
                hide-default-footer
                hide-default-header
                :headers="headers"
                :items="errorItems"
            >
                <template v-slot:item.details="{ item }">
                    <VBtn
                        class="mr-2"
                        @click.stop="detailsItem(item)"
                    >
                        Details
                    </VBtn>
                </template>
            </VDataTable>
        </VContainer>
    </VContainer>
</template>

<script>
    export default {
        name: 'ErrorsTable',
        props: {
            errorItems: {
                type: Array,
                required: true
            }
        },
        data () {
            return {
                headers: [
                    { text: '', align: 'center', value: 'parameter_value' },
                    { text: '', align: 'center', value: 'message' },
                    { text: '', align: 'center', value: 'count' },
                    { text: '', align: 'center', value: 'details' },
                ],
            };
        },
        methods: {
            detailsItem (item) {
                this.$emit('open', item);
            }
        }
    };
</script>

<style scoped lang="scss">

    $dark: #122737;
    $blue: #3C57DE;
    $gray: rgba(18, 39, 55, 0.5);

    .v-data-table {
        font-family: 'GilroySemiBold';
    }

    .header {
        align-items: center;
        text-align: center;
        text-transform: capitalize;
    }

    .container {

        .v-data-table {
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 6px;
            color: $gray;
            line-height: 14px;
            box-shadow: 0px 0px 28px rgba(194, 205, 223, 0.7);

            ::v-deep tr {
                min-height: 52px;
                display: flex;
                align-items: center;
                border-bottom: 1px solid rgba(0, 0, 0, 0.07) !important;

                &:last-child {
                    border-style: none !important;
                }

                td {
                    height: max-content;
                    flex: 1;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    max-width: calc(100% / 2);
                    word-break: break-all;
                    padding: 8px;

                    &:first-child {
                        padding-left: 32px;
                        justify-content: flex-start;
                    }
                }
            }
        }
    }

    ::v-deep .option-select {
        padding: 0;

        .v-input__slot {
            margin: 0;

            &:before,
            &:after {
                border-style: none;
            }

            .v-text-field__prefix {
                color: $dark;
                padding-left: 30px
            }

            .v-select__selection {
                &.v-select__selection--comma {
                    color: $blue;
                }
            }

            .v-select__slot
            {
                width: min-content;
                white-space: nowrap;
            }

            .v-icon {
                color: $blue;
            }
        }
        .v-text-field__details {
            display: none;
        }
    }
</style>