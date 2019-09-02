<template>
    <DefaultDropdown
        :items="items"
        :value="value"
        @change="changePeriod"
    />
</template>

<script>
    import {period} from "@/services/periodService";
    import DefaultDropdown from '@/components/common/DefaultDropdown';

    export default {
        name: "PeriodDropdown",
        components: {
            DefaultDropdown
        },
        props: {
            value: {
                type:String,
                required: true
            },
            items: {
                type: Array,
                default () {
                    return [
                        {title: 'Today', value: period.PERIOD_TODAY},
                        {title: 'Yesterday', value: period.PERIOD_YESTERDAY},
                        {title: 'Last 7 days', value: period.PERIOD_LAST_WEEK},
                        {title: 'Last month', value: period.PERIOD_LAST_MONTH},
                        {title: 'Last quartal', value: period.PERIOD_LAST_QUARTAL},
                        {title: 'All period', value: period.PERIOD_ALL}
                    ];
                }
            }
        },
        methods: {
            changePeriod(selectedItem) {
                this.$emit("change", selectedItem);
            }
        }
    };
</script>
