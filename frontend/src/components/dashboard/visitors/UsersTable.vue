<template>
    <VContainer class="t">
        <VRow
            class="header"
            fluid
        >
            <VCol>
                <VSelect
                    class="custom"
                    prefix="Show"
                    :items="options"
                    flat
                    v-model="selected"
                />
            </VCol>
            <VCol>
                <div>
                    Users
                </div>
            </VCol>
            <VCol>
                <div>
                    Users %
                </div>
            </VCol>
        </VRow>
        <VContainer>
            <VDataTable
                class="caption"
                hide-default-footer
                hide-default-header
                :headers="headers"
                :items="itemss"
                :items-per-page="5"
            />
        </VContainer>
    </VContainer>
</template>

<script>
    export default {
        data () {
            return {
                selected: 'browser',
                options: [ 'language', 'browser', 'country', 'city', 'browser', 'operating system', 'screen resolution' ],
                headers: [
                    { text: '1', align: 'center', value: 'option'},
                    { text: '1', align: 'center', value: 'users' },
                    { text: '1', align: 'center', value: 'percentage', },
                ],
                items: {
                    'language': [
                        {
                            option: 'us',
                            users: 67,
                            percentage: 50
                        },
                        {
                            option: 'en',
                            users: 67,
                            percentage: 50
                        },
                        {
                            option: 'fr',
                            users: 67,
                            percentage: 50
                        }
                    ],
                    'browser': [
                        {
                            option: 'IEwerterIEwerterIEwerterIEwerterIEwerterIEweIEwerterIEwerterIEwIEwerterIEwerEwerterIEweIEwerterIEwerterIEwIEwerterIEwerEwerterIEweIEwerterIEwerterIEwIEwerterIEwerterIEwerterIEwertererterIEwerterrter',
                            users: 55,
                            percentage: 34
                        },
                        {
                            option: 'Edge',
                            users: 77,
                            percentage: 34
                        },
                        {
                            option: 'Firefox',
                            users: 45,
                            percentage: 44
                        },
                        {
                            option: 'Chrome',
                            users: 84,
                            percentage: 34
                        },
                        {
                            option: 'iOS Safari',
                            users: 44,
                            percentage: 55
                        }]
                }
            }
        },
        computed: {
            itemss() {
                return this.items[this.selected];
            }
        }
    }
</script>

<style scoped lang="scss">
$dark: #122737;
$blue: #3C57DE;

.container .v-data-table {
    border-collapse: collapse;
    overflow: hidden;
    border-radius: 6px;
    color: rgba(18, 39, 55, 0.5);
    font-family: 'Gilroy';
    line-height: 14px;
    box-shadow: 0px 0px 28px rgba(194, 205, 223, 0.7);

    ::v-deep th {
        border: none !important;
        border-bottom: 1px solid rgba(0, 0, 0, 0.07) !important;
        height: 85px;
        font-size: 16px;
        line-height: 19px;
        font-family: 'GilroyLight';
    }
    ::v-deep tr {
        min-height: 52px;
        display: flex;
        align-items: center;
        border-bottom: 1px solid rgba(0, 0, 0, 0.07) !important;
        &:last-child {
            border-style: none !important;
        }
    }
    ::v-deep td {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        max-width: calc(100% / 3);
        word-break: break-all;
        padding: 8px;
        &:first-child {
            // justify-content: left;
            // margin-left: 30px;
        }
    }
}
::v-deep .custom.v-text-field>.v-input__control>.v-input__slot:before {
    border-style: none;
}
::v-deep .custom.v-text-field>.v-input__control>.v-input__slot:after {
    border-style: none;
}
::v-deep .custom {
    padding: 0;
    .v-input__slot {
        margin: 0;
    }
}
::v-deep .v-text-field__prefix {
    color: $dark;
    padding-left: 10px
}

::v-deep .v-select__selection.v-select__selection--comma {
    color: $blue;
    text-transform: capitalize;
}

::v-deep .v-list-item,
::v-deep .v-select__slot
{
    font-family: 'Gilroy';
    text-transform: capitalize;
}

::v-deep .v-select__slot {
    width: min-content;
    white-space: nowrap;
}
::v-deep .v-text-field__details {
        display: none;
}
.header {
    height: 52px;
    justify-content: center;
    align-items: center;
    font-family: 'Gilroy';
    margin: 16px 16px;
}
::v-deep .header > * {
    text-align: center;
}

.t {
    max-width: 1032px;
}
</style>