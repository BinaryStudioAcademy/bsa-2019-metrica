<template>
    <VRow class="justify-center">
        <VCol class="d-flex col-5 justify-center align-items-center">
            <GChart
                class="pb-2 align-self-end"
                type="PieChart"
                :data="data"
                :options="options"
            />
        </VCol>
        <VCol>
            <VSubheader
                v-text="legend.title"
                class="legend-title grey--text text--darken-1 pl-0"
            />
            <VList>
                <LegendItem
                    v-for="(item, key) in legend.data"
                    :key="key"
                    :item="item"
                />
            </VList>
        </VCol>
    </VRow>
</template>

<script>
    import { GChart } from "vue-google-charts";
    import LegendItem from "@/components/widgets/LegendItem";
    export default {
        name: "PieChartItem",
        components: { GChart, LegendItem },
        props: {
            data: {
                type: Array,
                required: true
            },
            slices: {
                type: Object,
                required: true
            },
            legend: {
                type: Object,
                required: true
            }
        },
        mounted() {
            console.log(this.data);
        },
        data() {
            return {
                options: {
                    slices: this.slices,
                    chartArea: {
                        backgroundColor: 'transparent',
                        width: '85%',
                        height: '85%'
                    },
                    width: 110,
                    height: 110,
                    pieHole: 0.87,
                    pieSliceBorderColor: 'none',
                    legend: 'none',
                    pieSliceText: 'none',
                    tooltip: {
                        trigger: 'hover'
                    },
                },
            };
        }
    };
</script>

<style scoped lang="scss">
.legend-title {
    font-size: 14px;
    line-height: 16px;
}
.v-subheader {
    height: 20px;
}
</style>