<template>
    <VContainer>
        <VSubheader
            class="header my-3 text-dark"
            fluid
        >
            Summary
        </VSubheader>
        <VLayout class="pie-container">
            <VFlex
                lg4
                md4
                hidden-sm-and-down
                height="100%"
                class="img-card"
            >
                <GChart
                    type="PieChart"
                    :data="chartData"
                    :options="chartOptions"
                />
            </VFlex>
            <VFlex
                lg8
                md8
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
                        <VRow class="align-center">
                            <VCheckbox
                                class="radio"
                                :label="visitor.title"
                                :color="visitor.color"
                                hide-details
                                input-value="true"
                                value
                            />
                            <VLabel>{{ visitor.percentageDiff }}</VLabel>
                        </VRow>
                    </VListItem>
                </VList>
            </VFlex>
        </VLayout>
    </VContainer>
</template>

<script>
    import {GChart} from 'vue-google-charts';

    export default {
        components: {
            GChart
        },
        props: {
            data: {
                type: Array,
                required: true,
                default: () => []
            },
            pieHole: {
                type: Number,
                default: 0.95
            },
            legend: {
                type: Array,
                required: true,
                default: () => [],
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
    font-size: 12px;
    line-height: 14px;
}
.radio {
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    border-radius: 50%;
}
</style>