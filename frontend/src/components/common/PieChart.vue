<template>
    <VContainer>
        <VRow>
            <VCol>
                <VSubheader
                    class="my-3 header text-dark"
                    fluid
                >
                    Summary
                </VSubheader>
            </VCol>
        </VRow>
        <VContainer
            class="pie-container position-relative"
            wrap
        >
            <VRow>
                <VSubheader
                    v-text="legend.title"
                    class="legend-title grey--text text--darken-1 col-7 offset-5"
                />
            </VRow>
            <Spinner v-if="isFetching" />
            <VRow>
                <VCol class="col-5">
                    <GChart
                        type="PieChart"
                        :data="chartData"
                        :options="chartOptions"
                    />
                </VCol>
                <VCol class="d-flex flex-column flex-grow-1 pl-4 justify-center">
                    <VList>
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
                </VCol>
            </VRow>
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
                    height: 150,
                    width: 150,
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
                            offset: 0.04,
                        },
                    }
                }
            };
        },
    };
</script>

<style scoped lang="scss">
.pie-container {
    background-color: white;
    border-radius: 6px;
    box-shadow: 0px 0px 28px rgba(194, 205, 223, 0.7);
    max-width: 500px;

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
.legend-title {
    font-family: Gilroy;
    font-size: 14px;
    line-height: 16px;
}
.title, .percent {
    font-size: 16px !important;
    font-family: 'GilroySemiBold' !important;
}
.v-subheader {
    text-align: start;
}
</style>
