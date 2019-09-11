<template>
    <VContainer class="piechart">
        <VRow>
            <VCol>
                <div
                    class="my-5 header text-dark"
                    fluid
                >
                    Summary
                </div>
            </VCol>
        </VRow>
        <VContainer
            class="pie-container position-relative d-flex pr-6"
        >
            <Spinner v-if="isFetching" />
            <GChart
                class="align-self-end"
                type="PieChart"
                :data="chartData"
                :options="chartOptions"
            />
            <VList class="flex-grow-1 ml-3">
                <div
                    class="grey--text text--darken-1 pb-3"
                >
                    {{ legend.title }}
                </div>
                <VListItem
                    class="justify-space-between align-center pa-0"
                    v-for="visitor in legend.data"
                    :key="visitor.title"
                >
                    <VIcon
                        :color="visitor.color"
                        size="12"
                    >
                        mdi-circle
                    </VIcon>
                    <div
                        class="title pl-2 grey--text flex-grow-1"
                    >
                        {{ visitor.title }}
                    </div>
                    <div
                        class="percent grey--text"
                    >
                        {{ visitor.percentageDiff }}%
                    </div>
                </VListItem>
            </VList>
        </VContainer>
    </VContainer>
</template>

<script>
    import {GChart} from 'vue-google-charts';
    import Spinner from '../utilites/Spinner';
    export default {
        components: {
            GChart,
            Spinner
        },
        props: {
            chartData: {
                type: Array,
                required: true,
            },
            pieHole: {
                type: Number,
                default: 0.95
            },
            legend: {
                type: Object,
                required: true,
            },
            isFetching: {
                type: Boolean,
                required: true,
            }
        },
        data() {
            return {
                chartOptions: {
                    chartArea: {
                        width: '80%',
                        height: '80%'
                    },
                    height: 128,
                    width: 128,
                    pieHole: this.pieHole,
                    legend: 'none',
                    pieSliceText: 'none',
                    tooltip: {
                        trigger: 'none',
                    },
                    slices: {
                        0: {
                            color: '#3C57DE',
                        },
                        1: {
                            color: '#1BC3DA',
                        },
                    }
                }
            };
        },
    };
</script>

<style scoped lang="scss">
.piechart {
    max-width: 500px;
}
.pie-container {
    background-color: white;
    border-radius: 6px;
    box-shadow: 0px 0px 28px rgba(194, 205, 223, 0.7);

    .chart-card {
        min-width: 165px;
    }
}
.header {
    text-transform: capitalize;
    font-family: 'Gilroy';
    font-size: 16px;
    line-height: 19px;
}
.legend-title,
.title,
.percent {
    font-size: 14px !important;
    font-family: 'GilroySemiBold' !important;
}
.v-subheader {
    text-align: start;
}
</style>
