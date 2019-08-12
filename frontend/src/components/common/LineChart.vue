<template>
    <GChart
        type="LineChart"
        :data="chartData"
        :options="chartOptions"
    />
</template>

<script>
    import { GChart } from 'vue-google-charts'
    export default {
        components: {
            GChart,
        },

        props: {
            data: {
                type: Array,
                required: true
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
            }
        },

        computed: {
            chartData(){
                let tooltipObj = {'type': 'string', 'role': 'tooltip', 'p': {'html': true}};
                let pointStyle = 'point { stroke-color: #3C57DE; size: 5.5; shape-type: circle; fill-color: #FFFFFF; }';
                let data = [];
                data.push([{type: 'string', name: 'xLabel'}, '', 'yValue', {'type': 'string', 'role': 'style'}, tooltipObj]);

                this.data.forEach( (element) => {
                    data.push([element.xLabel, element.value, element.value, pointStyle, this.tooltip(element.value, element.indication)])
                });

                return data;
            }
        },

        methods: {
            tooltip(value, indication) {
                return ' <div class=\'custom-tooltip\'>\n' +
                    '        <div class=\'tooltip-first\'>\n' +
                    `          ${value}\n` +
                    '        </div>\n' +
                    '        <div class=\'tooltip-second\'>\n' +
                    '            <img class="tooltip-arrow" src="/assets/icons/arrow-up.svg#root" alt="arrow-up">\n' +
                    `            ${indication}%\n` +
                    '        </div>\n' +
                    '</div>'
            },

        }
    }
</script>

<style lang="scss">
    div.google-visualization-tooltip {
        margin-left: -100px !important;
        z-index:+1;
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
    }

    .custom-tooltip {
        box-sizing: border-box;
        border-radius: 6px;
        width: 150px;
        background: #3C57DE;
    }

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
    }

    .tooltip-arrow {
        width: 8px;
        height: 18px;
    }
</style>