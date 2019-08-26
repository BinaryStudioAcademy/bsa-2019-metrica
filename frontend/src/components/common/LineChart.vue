<template>
    <VContainer>
        <Spinner
            v-if="isFetching"
        />
        <VFlex
            v-if="!this.data.length"
        >
            <VCardTitle
                primary-title
                class="justify-center grey--text"
            >
                There is no data to display!
            </VCardTitle>
        </VFlex>
        <GChart
            type="LineChart"
            v-else
            :data="chartData"
            :options="chartOptions"
        />
    </VContainer>
</template>

<script>
    import { GChart } from 'vue-google-charts';
    import Spinner from '../utilites/Spinner';

    export default {
        components: {
            GChart,
            Spinner,
        },

        props: {
            data: {
                type: Array,
                required: true
            },
            isFetching: {
                type: Boolean,
                required: true,
            }
        },

        data() {
            return {
                chartOptions: {
                    tooltip: {
                        isHtml: true,
                        ignoreBounds: true,
                        trigger: 'selection'
                    },
                    curveType: 'function',
                    legend: {
                        position: 'none'
                    },
                    lineWidth: 1,
                    pointSize: 10,
                    pointShape: { type: 'circle', fill: 'none' },
                    series: [
                        { targetAxisIndex: 0, visibleInLegend: false, pointSize: 0, lineWidth: 0, pointsVisible: false},
                        { targetAxisIndex: 1, color: '#3C57DE', pointsVisible: true},
                        {color: 'red'}
                    ],
                    vAxes: {
                        0: { textPosition: 'none' },
                        1: {}
                    },
                    hAxis: {
                        ticks: [{v:0, f:'thirty two'}, 1, {v:2, f:'thirty two'}, {v:"01:00:00", f:'sixty four'}] ,
                        textStyle: {
                            color: '#b8bec3',
                            fontName: 'Gilroy',
                            fontSize: 12,
                            lineHeight: 14,
                            letterSpacing: 0.533333,
                        },
                    },
                    crosshair:
                        {
                            color: '#ededed',
                            trigger: 'focus',
                            orientation: 'vertical'
                        },
                    vAxis: {
                        format: 'short',
                        count: 3,
                        minValue: 1,
                        baselineColor: 'none',
                        minorGridlines: {
                            count: 0
                        },
                        textStyle: {
                            color: '#b8bec3',
                            fontName: 'Gilroy',
                            fontSize: 12,
                            lineHeight: 14,
                            letterSpacing: 0.533333,
                        }
                    }
                },
            };
        },

        computed: {
            chartData(){
                if (!this.data.length) {
                    return [];
                }

                const tooltipObj = {'type': 'string', 'role': 'tooltip', 'p': {'html': true}};
                const pointStyle = 'point { stroke-color: #3C57DE; size: 5; shape-type: circle; fill-color: #FFFFFF; }';
                let tmpData = this.data.map( element =>
                    [element.date, parseInt(element.value), parseInt(element.value), pointStyle, this.tooltip(element.value, element.date)]
                );
                tmpData.unshift([{type: 'string', name: 'date'}, '', 'yValue', {'type': 'string', 'role': 'style'}, tooltipObj]);
                return tmpData;
            }
        },

        methods: {
            tooltip(value, date) {
                let tooltip = `<div class='custom-google-line-chart-tooltip'>
                    <div class='tooltip-first'>
                        ${value}
                    </div>
                    <div class='tooltip-second'>
                        ${date}
                    </div>
                </div>`;
                return tooltip;
            },
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
        height:auto;
        font-family: Gilroy;
        font-size: 18px;
        line-height: 21px;
        align-items: center;
        text-align: center;
        letter-spacing: 0.533333px;
        color: #FFFFFF;
        border: 0;
        border-radius: 6px;

        .custom-google-line-chart-tooltip {
            box-sizing: border-box;
            border-radius: 6px;
            min-width: 175px;
            background: #3C57DE;

            .tooltip-first {
                left: 0;
                width: 47%;
                display: inline-block;
                background: #4966F2;
                padding: 15px 10px;
                border-radius: 6px 0 0 6px;
            }

            .tooltip-second {
                width: 49%;
                display: inline-block;
                padding: 15px 10px;

                .tooltip-arrow {
                    width: 8px;
                    height: 18px;
                }
            }
        }
    }
</style>