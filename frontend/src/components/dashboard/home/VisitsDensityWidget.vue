<template>
    <div class="card bg-white visits-widget rounded shadow text-dark">
        <div class="widget-title">
            Users by time of day
        </div>
        <VueApexCharts
            type="heatmap"
            height="350"
            :options="chartOptions"
            :series="series"
            class="visits-heatmap"
        />
        <PeriodDropdown
            :value="getSelectedPeriod"
            @change="changeSelectedPeriod"
        />
    </div>
</template>

<script>
    import VueApexCharts from 'vue-apexcharts';
    import PeriodDropdown from "@/components/dashboard/common/PeriodDropdown.vue";
    import {mapGetters, mapActions} from 'vuex';
    import {GET_SELECTED_PERIOD, GET_SELECTED_PARAMETER} from "@/store/modules/geo_location/types/getters";
    import {CHANGE_SELECTED_PERIOD} from "@/store/modules/geo_location/types/actions";

    export default {
        name: "VisitsDensityWidget",
        components: {
            VueApexCharts,
            PeriodDropdown
        },
        data() {
            return {
                days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                time: ['12am', '2am', '4am', '6am', '8am', '10am', '12pm', '2pm', '4pm', '6pm', '8pm', '10pm'],
                series: [],
                chartOptions: {
                    chart: {
                        toolbar: {
                            show: false
                        },
                        fontFamily: 'Gilroy'
                    },
                    dataLabels: {
                        enabled: false
                    },
                    colors: ["#3C57DE"],
                    grid: {
                        yaxis: {
                            lines: {
                                show: false
                            }
                        },
                        padding: {
                            left: 15
                        },
                    },
                    legend: {
                        show: false
                    },
                    noData: {
                        text: 'No data available',
                        style: {
                            color: '#88929a',
                            fontSize: '18px'
                        }
                    },
                    plotOptions: {
                        heatmap: {
                            radius: 6,
                        }
                    },
                    states: {
                        hover: {
                            filter: {
                                type: 'none',
                            }
                        },
                        active: {
                            filter: {
                                type: 'none',
                            }
                        },
                    },
                    tooltip: {
                        enabled: true,
                        custom: ({series, seriesIndex, dataPointIndex}) => {
                            return `<span style="padding: 10px">${series[seriesIndex][dataPointIndex]}</span>`;
                        }
                    },
                    xaxis: {
                        labels: {
                            show: true
                        },
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false,
                        },
                        tooltip: {
                            enabled: false
                        }
                    },
                    yaxis: {
                        opposite: true,
                        reversed: true,
                        labels: {
                            align: 'right'
                        }
                    }
                }
            };
        },
        computed: {
            ...mapGetters('geo_location', {
                getSelectedPeriod: GET_SELECTED_PERIOD,
                getSelectedParameter: GET_SELECTED_PARAMETER,
            }),
        },
        created() {
            this.generateData();
            this.chartOptions.xaxis.labels.show = this.series.length !== 0;
        },
        methods: {
            ...mapActions('geo_location', {
                changeSelectedPeriod: CHANGE_SELECTED_PERIOD
            }),
            generateData () {
                this.time.forEach((timeValue) => {
                    let item1 = {};
                    item1.name = timeValue;
                    item1.data = [];

                    let item2 = {};
                    item2.name = '';
                    item2.data = [];

                    this.days.forEach((dayValue) => {
                        item1.data.push({
                            x: dayValue,
                            y: Math.floor(Math.random() * 1000)
                        });
                        item2.data.push({
                            x: dayValue,
                            y: Math.floor(Math.random() * 1000)
                        });
                    });

                    this.series.push(item1);
                    this.series.push(item2);
                });
            }
        }
    };
</script>

<style scoped>
    .visits-widget {
        padding: 2rem;
    }

    .widget-title {
        margin-left: 12px;
    }

    .visits-heatmap {
        margin-top: -1rem;
        margin-right: -1.5rem;
    }
</style>