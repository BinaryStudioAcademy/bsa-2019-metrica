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

        data() {
            return {
                array: [],
                chartOptions: {
                    chart: {
                        title: 'Company Performance',
                        subtitle: 'Sales, Expenses, and Profit: 2014-2017',
                    },
                    tooltip: {
                        isHtml: true,
                        ignoreBounds: true,
                        trigger: 'selection'
                    },
                    curveType: 'function',
                    legend: {
                        position: 'none'
                    },
                    series: [
                        { targetAxisIndex: 0, visibleInLegend: false, pointSize: 0, lineWidth: 0, pointsVisible: false},
                        { targetAxisIndex: 1, color: '#3C57DE', pointsVisible: true},
                        {color: 'red'}
                    ],
                    vAxes: {
                        0: { textPosition: 'none' },
                        1: {}
                    },
                },
            }
        },

        computed: {
            chartData(){
                let tooltipObj = {'type': 'string', 'role': 'tooltip', 'p': {'html': true}};
                let data = [];
                data.push([{type: 'date'}, '', 'Value', tooltipObj]);

                this.array.forEach( (element) => {
                    data.push([element.date, element.value, element.value, this.tooltip(element.value, element.indication)])
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
                '           <i class="far fa-long-arrow-up tooltip-arrow"></i>' +
                `          ${indication}\n` +
                '        </div>\n' +
                '</div>'
            },

            getRndInteger(min, max) {
                return Math.floor(Math.random() * (max - min) ) + min;
            }

        },
        created() {
            for (let i = 1; i < 20; i++) {
                const item = {
                    date: new Date(2019, 9, i),
                    value: this.getRndInteger(100,2000),
                    indication: this.getRndInteger(2,30),
                };
                this.array.push(item);
            }
        }
    }
</script>

<style lang="scss">
    div.google-visualization-tooltip {
        margin-left: 100px !important;
        z-index:+1;
        width: auto;
        height:auto;
        font-family: Gilroy-Medium;
        font-size: 18px;
        line-height: 21px;
        align-items: center;
        text-align: center;
        letter-spacing: 0.533333px;
        color: #FFFFFF;
    }

    .custom-tooltip {
        background: #3C57DE!important;
        border-radius: 6px;
        width: 150px;
    }

    .tooltip-first {
        width: 47%;
        display: inline-block;
        background: #4966F2;
        padding: 15px 10px;
    }

    .tooltip-second {
        width: 47%;
        display: inline-block;
        padding: 15px 10px;
    }

    .tooltip-arrow {
        background: #1BC4DB;
    }
</style>