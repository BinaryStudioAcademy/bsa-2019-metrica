<template>
    <VContainer clas="position-relative">
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
    import { period } from '@/services/periodService';
    import moment from 'moment';

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
            },
            interval: { type: String, required: true }
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
                let tmpData = this.data.map( element => {
                    let date = this.transformDate(element.date);
                    return  [date, parseInt(element.value), parseInt(element.value), pointStyle, this.tooltip(element)];
                });
                tmpData.unshift([{type: 'string', name: 'date'}, '', 'yValue', {'type': 'string', 'role': 'style'}, tooltipObj]);
                return tmpData;
            }
        },

        methods: {
            tooltip(element) {
                return `<div class='custom-google-line-chart-tooltip white--text'>
                    <div class='tooltip-first primary lighten-1'>
                        ${element.value}
                    </div>
                    <div class='tooltip-second'>
                        ${this.tooltipDate(element.date)}
                    </div>
                </div>`;
            },
            tooltipDate(date) {
                return this.transformDate(date);
            },
            transformDate(date){
                switch(this.interval) {
                case period.PERIOD_TODAY:
                case period.PERIOD_YESTERDAY:
                    return moment.unix(date).format("HH:mm");
                default:
                    return moment.unix(date).format("MM/DD/YYYY");
                }
            }
        }
    };
</script>

<style lang="scss" scoped>
    ::v-deep svg path {
        fill: none;
    }

    ::v-deep div.google-visualization-tooltip {
        margin-left: -100px;
        font-family: Gilroy;
        font-size: 18px;
        line-height: 21px;
        letter-spacing: 0.533333px;
        border: 0;
        border-radius: 6px;

        .custom-google-line-chart-tooltip {
            box-sizing: border-box;
            border-radius: 6px;
            min-width: 176px;
            height: 48px;
            display: flex;
            align-items: center;
            background: #3C57DE;

            .tooltip-first {
                flex: 1;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 6px 0 0 6px;
            }

            .tooltip-second {
                text-align: center;
                padding: 0 8px;
                flex: 1;
            }
        }
    }
</style>