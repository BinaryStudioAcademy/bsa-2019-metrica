<template>
    <GChart
        type="PieChart"
        :data="chartData"
        :options="chartOptions"
    />
</template>

<script>
    import {GChart} from 'vue-google-charts';

    export default {
        components: {
            GChart
        },
        props: {
            title: {
                type: String,
                default: 'Outcome'
            },
            data: {
                type: Array,
                required: true,
                default: () => []
            },
            pieHole: {
                type: Number,
                default: 0.9
            }
        },
        data() {
            return {
                chartData: this.data,
                chartOptions: {
                    title: this.title,
                    pieHole: this.pieHole,
                    pieSliceBorderColor: 'black',
                    legend: 'none',
                    pieSliceText: 'none',
                    tooltip: {
                        isHtml: true,
                        ignoreBounds: true,
                        trigger: 'none',
                    },
                    slices: {
                        newVisitors: {
                            colors: '#3C57DE',
                        },
                        returnVisitors: {
                            colors: 'black',
                        },
                    }
                }
            };
        }
    };
</script>


<style lang="scss" scoped>
    ::v-deep svg path {
        fill: none;
    }

    ::v-deep div.google-visualization-tooltip {
        margin-left: -100px;
        width: auto;
        height: auto;
        font-family: Gilroy;
        font-size: 18px;
        line-height: 21px;
        align-items: center;
        text-align: center;
        letter-spacing: 0.533333px;
        color: #FFFFFF;
        border: 10px;
        border-radius: 6px;
    }
</style>
