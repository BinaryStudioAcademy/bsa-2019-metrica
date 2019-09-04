<template>
    <VContainer
        p-0
        class="users-table"
    >
        <VRow
            class="header my-3"
            fluid
        >
            <VCol>
                <VSelect
                    class="option-select"
                    prefix="Show"
                    :items="options"
                    flat
                    v-model="selected"
                    @change="changeSelect"
                />
            </VCol>
            <VCol>
                {{ option }}
            </VCol>
        </VRow>
        <VDataTable
            class="caption"
            hide-default-footer
            hide-default-header
            :headers="headers"
            :items="items"
        />
    </VContainer>
</template>

<script>
    export default {
        name: 'GroupedTable',
        props: {
            items: {
                type: Array,
                required: true
            },
            option: {
                type: String,
                required: true
            }
        },
        data () {
            return {
                selected: 'browser',
                options: [
                    {
                        text: 'Page',
                        value: 'page'
                    },
                    {
                        text: 'Browser',
                        value: 'browser'
                    },
                    {
                        text: 'Country',
                        value: 'country'
                    },
                ],
                headers: [
                    { text: '', align: 'center', value: 'name' },
                    { text: '', align: 'center', value: 'value' },
                ],
            };
        },
        methods: {
            changeSelect () {
                this.$emit('change', this.selected);
            }
        }
    };
</script>

<style scoped lang="scss">

    $dark: #122737;
    $blue: #3C57DE;
    $gray: rgba(18, 39, 55, 0.5);

    .users-table {
        font-family: 'Gilroy';
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

    ::v-deep .v-list-item {
        font-family: 'Gilroy';
        text-transform: capitalize;
    }
</style>