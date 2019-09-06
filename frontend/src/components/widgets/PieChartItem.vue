<template>
    <div class="d-flex">
        <GChart
            class="align-self-end"
            type="PieChart"
            :data="chartData"
            :options="chartOptions"
        />
        <div class="flex-grow-1 pl-4">
            <VSubheader
                v-text="dataType"
                class="legend-title grey--text text--darken-1 pl-0 mb-3"
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
        </div>
    </div>
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
                        trigger: 'none'
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
/*.v-list {
    width: max-content;
}*/
</style>