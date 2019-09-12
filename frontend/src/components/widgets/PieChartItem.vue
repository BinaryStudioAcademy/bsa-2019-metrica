<template>
    <div class="d-flex flex-column">
        <VRow>
            <VSubheader
                v-text="dataType"
                class="legend-title grey--text text--darken-1 mt-3 pl-3 col-7 offset-5"
            />
        </VRow>
        <VRow>
            <VCol class="d-flex col-5">
                <GChart
                    class="align-self-center"
                    type="PieChart"
                    :data="chartData"
                    :options="chartOptions"
                />
            </VCol>
            <VCol class="d-flex col-7 align-center">
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
                        width: '80%',
                        height: '80%'
                    },
                    width: 128,
                    height: 128,
                    pieHole: 0.9,
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
.v-list {
    width: 100%;
}
</style>