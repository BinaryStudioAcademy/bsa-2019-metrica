<template>
    <div class="container">
        <GChart
            type="GeoChart"
            :data="chartData"
            :options="chartOptions"
            class="map"
        />
    </div>
</template>


<script>
    import { GChart } from 'vue-google-charts';
    import config from "@/config";

    export default {
        components: {
            GChart
        },
        props: {
            dataItems: {
                type: Array,
                required: true,
            },
            parameter: {
                type: String,
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
                    legend: 'none',
                    colorAxis: {colors: ['#D4DAF8', '#3C57DE']},
                    datalessRegionColor: '#ECF3FF'
                },
                mapsApiKey: config.getGoogleMapsApiKey()
            };
        },
        computed: {
            chartData () {
                if (!this.dataItems.length) {
                    return [];
                }

                const tooltipObj = {'type': 'string', 'role': 'tooltip', 'p': {'html': true}};
                let dataArray = [['Country', '']];
                dataArray = this.dataItems.map((item) =>
                    [item.country, +item[this.parameter], this.tooltip(item.country, item[this.parameter])]
                );
                dataArray.unshift([{type: 'string', name: 'Country'},{type: 'number', name: 'value'}, tooltipObj]);
                return dataArray;
            }
        },
        methods: {
            tooltip(country, value) {
                return ' <div class=\'custom-google-map-chart-tooltip\'>\n' +
                    '        <div class=\'tooltip-country\'>\n' +
                    `          ${country}\n` +
                    '        </div>\n' +
                    '        <div class=\'tooltip-value\'>\n' +
                    `            ${value}\n` +
                    '        </div>\n' +
                    '</div>';
            },

        }
    };

</script>

<style lang="scss" scoped>
    .map {
        padding-top: 45px;

        ::v-deep div.google-visualization-tooltip {
            font-family: Gilroy;

            .custom-google-map-chart-tooltip {
                display: flex;
                border: 1px solid rgba(60, 87, 222, 0.52);
                box-shadow: 2px 10px 16px rgba(0, 0, 0, 0.16);
                border-radius: 6px;
                padding: 10px;

                .tooltip-country {
                    color: rgba(0, 0, 0, 0.5);
                    font-size: 14px;
                }
                .tooltip-value {
                    color: #000000;
                    font-size: 14px;
                    padding-left: 15px;
                }
            }
        }
    }
</style>