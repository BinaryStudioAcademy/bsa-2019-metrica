<template>
    <VContainer>
        <VSubheader
            class="header my-3 text-dark"
            fluid
        >
            Summary
        </VSubheader>
        <VLayout class="pie-container position-relative">
            <VFlex
                lg4
                md4
                hidden-sm-and-down
                height="100%"
                class="img-card"
            >
                <Spinner v-if="isFetching" />
                <GChart
                    type="PieChart"
                    :data="chartData"
                    :options="chartOptions"
                />
            </VFlex>
            <VFlex
                lg5
                md5
                hidden-sm-and-down
                height="100%"
                class="img-card"
            >
                <VSubheader
                    v-text="legend.title"
                    class="legend-title text-dark"
                />
                <VList>
                    <VListItem
                        v-for="visitor in legend.data"
                        :key="visitor.title"
                    >
                        <VRow class="align-center justify-content-between">
                            <VIcon
                                :color="visitor.color"
                                small
                            >
                                mdi-circle
                            </VIcon>
                            <VLabel>{{ visitor.title }}</VLabel>
                            <VLabel>
                                <VIcon
                                    :color="visitor.color"
                                    small
                                >
                                    mdi-arrow-up
                                </VIcon>
                                {{ visitor.percentageDiff }}%
                            </VLabel>
                        </VRow>
                    </VListItem>
                </VList>
            </VFlex>
        </VLayout>
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
            data: {
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
                chartData: this.data,
                chartOptions: {
                    width: 200,
                    height: 200,
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
        }
    };
</script>

<style scoped lang="scss">
.pie-container {
    background-color: white;
}
.header {
    align-items: center;
    text-align: center;
    text-transform: capitalize;
    font-family: 'Gilroy';
    padding-bottom: 10px;
    font-size: 16px;
    line-height: 19px;
}
.legend-title {
    font-family: Gilroy;
    font-size: 14px;
    line-height: 16px;
}
.radio {
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    border-radius: 50%;
}
.dot {
    height: 8px;
    width: 8px;
    border-radius: 50%;
    display: inline-block;
}
</style>
