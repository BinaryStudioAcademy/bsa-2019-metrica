<template>
    <VSelect
        :items="items"
        item-text="title"
        item-value="value"
        class="option-select no-details"
        :value="value"
        solo
        return-object
        @change="changePeriod"
    />
</template>

<script>
    import {period} from "@/services/periodService";

    export default {
        name: "PeriodDropdown",
        props: {
            value: {
                type:String,
                required: true
            },
        },
        data() {
            return {
                items: [
                    {title: 'Today', value: period.PERIOD_TODAY},
                    {title: 'Yesterday', value: period.PERIOD_YESTERDAY},
                    {title: 'Last 7 days', value: period.PERIOD_LAST_WEEK},
                    {title: 'Last month', value: period.PERIOD_LAST_MONTH},
                    {title: 'Last quartal', value: period.PERIOD_LAST_QUARTAL},
                    {title: 'All period', value: period.PERIOD_ALL}
                ]
            };
        },
        methods: {
            changePeriod(selectedItem) {
                this.$emit("change", selectedItem);
            }
        }
    };
</script>

<style lang="scss" scoped>
    $dark: #122737;
    $blue: #3C57DE;

    .option-select {
        padding: 0;
        max-width: 140px;

        ::v-deep .v-input__control {
            min-height: auto;

            .v-input__slot {
                border-radius: 6px !important;
                min-height: auto !important;
            }

            .v-select__selection {
                font-size: 12px;
                line-height: 14px;
                display: flex;
                align-items: center;
                letter-spacing: 0.533333px;
                color: #122737;
            }

            .v-icon {
                color: $blue;
            }
        }
    }

    ::v-deep .v-list-item .v-list-item__title {
        font-size: 12px;
        line-height: 14px;
        display: flex;
        align-items: center;
        letter-spacing: 0.533333px;
        color: $dark;
    }
</style>