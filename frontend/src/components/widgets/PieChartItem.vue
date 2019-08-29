<template>
    <VRow class="justify-center">
        <VCol class="d-flex col-5 justify-center align-items-center">
            <GChart
                class="pb-2 align-self-end"
                type="PieChart"
                :data="chartData"
                :options="chartOptions"
            />
        </VCol>
        <VCol>
            <VSubheader
                v-text="dataType"
                class="legend-title grey--text text--darken-1 pl-0"
            />
            <VList>
                <LegendItem
                    v-for="(item, key) in data"
                    :key="key"
                    :color="item.color"
                    :title="item.title"
                    :percent="item.percent"
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
            dataType: {
                type: String,
                required: true
            }
        },
        computed: {
            chartOptions() {
                return {
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
                    slices: this.slices
                };
            },
            slices() {
                return this.data.map(item => {
                    return { color: item.color };
                });
            },
            chartData() {
                let data =
                    this.data.map(item => {
                        return [item.title, item.percent];
                    });
                data.unshift(['Value', 'Type']);
                return data;
            }
        },
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