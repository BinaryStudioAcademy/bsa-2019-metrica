<template>
    <div class="container">
        <GChart
            type="GeoChart"
            :settings="settings"
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
                    showInfoWindow: false,
                    tooltip: {
                        isHtml: true,
                        ignoreBounds: true
                    },
                    legend: 'none',
                    colorAxis: {colors: ['#D4DAF8', '#3C57DE']},
                    datalessRegionColor: '#ECF3FF'
                },
                tooltipRow: [{
                    type: 'string',
                    name: 'Country'
                }, {
                    type: 'number',
                    name: 'value'
                }, {
                    type: 'string',
                    role: 'tooltip',
                    p: { html: true }
                }],
                settings: {
                    packages: ['map'],
                    mapsApiKey: config.getGoogleMapsApiKey()
                }
            };
        },
        computed: {
            chartData () {
                const tooltipRow = this.tooltipRow;
                const tableRows = this.dataItems.map((item) => [
                    item.country,
                    Number(item[this.parameter]) || 0,
                    `<span class='tooltip-value'>${item[this.parameter]}</span>`
                ]);

                return [
                    tooltipRow
                ].concat(tableRows);
            }
        },
    };

</script>

<style lang="scss" scoped>
    .map {
        padding-top: 45px;

        ::v-deep div.google-visualization-tooltip {
            font-family: Gilroy;
            border: 1px solid rgba(60, 87, 222, 0.52);
            box-shadow: 2px 10px 16px rgba(0, 0, 0, 0.16);
            border-radius: 6px;
            padding: 10px;
            width: auto !important;

            .google-visualization-tooltip-item-list {
                display: flex;
                margin: 0;
                padding: 0;
            }

            .google-visualization-tooltip-item {
                margin: 0;
                padding: 0;
                font-size: 14px;
            }

            .google-visualization-tooltip-item > span:not(.tooltip-value) {
                color: rgba(0, 0, 0, 0.5) !important;
            }

            .google-visualization-tooltip-item > .tooltip-value {
                color: #000000;
                padding-left: 15px;
            }
        }

    }
</style>