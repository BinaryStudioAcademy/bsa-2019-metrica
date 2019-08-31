<template>
    <div class="card bg-white visits-widget rounded shadow text-dark">
        <Spinner
            v-if="isFetching"
        />
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
    import {
        GET_SELECTED_PERIOD,
        GET_VISITS_DATA,
        IS_FETCHING
    } from "@/store/modules/visits_density_widget/types/getters";
    import {
        CHANGE_SELECTED_PERIOD,
        FETCH_WIDGET_DATA
    } from "@/store/modules/visits_density_widget/types/actions";
    import Spinner from "@/components/utilites/Spinner";
    import _ from "lodash";

    export default {
        name: "VisitsDensityWidget",
        components: {
            VueApexCharts,
            PeriodDropdown,
            Spinner
        },
        data() {
            return {
                days: {
                    '0': 'Sun',
                    '1': 'Mon',
                    '2': 'Tue',
                    '3': 'Wed',
                    '4': 'Thu',
                    '5': 'Fri',
                    '6': 'Sat'
                },
                hours: {
                    '0': '12am',
                    '2': '2am',
                    '4': '4am',
                    '6': '6am',
                    '8': '8am',
                    '10': '10am',
                    '12': '12pm',
                    '14': '2pm',
                    '16': '4pm',
                    '18': '6pm',
                    '20': '8pm',
                    '22': '10pm'
                },
                series: [],
                chartOptions: {
                    chart: {
                        toolbar: {
                            show: false
                        },
                        fontFamily: 'Gilroy'
                    },
                    colors: ["#3C57DE"],
                    dataLabels: {
                        enabled: false
                    },
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
                    noData: {
                        text: 'No data available',
                        style: {
                            color: '#88929a',
                            fontSize: '18px'
                        }
                    },
                    legend: {
                        show: false
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
            ...mapGetters('visits_density_widget', {
                getSelectedPeriod: GET_SELECTED_PERIOD,
                getVisitsData: GET_VISITS_DATA,
                isFetching: IS_FETCHING
            }),
        },
        created() {
            this.fetchWidgetData();
            this.drawHeatmap();
            this.chartOptions.xaxis.labels.show = this.series.length !== 0;
        },
        methods: {
            ...mapActions('visits_density_widget', {
                changeSelectedPeriod: CHANGE_SELECTED_PERIOD,
                fetchWidgetData: FETCH_WIDGET_DATA
            }),
            drawHeatmap () {
                for (let hour = 0; hour < 24; hour++) {
                    let row = {};
                    row.name = this.hours[hour] || '';
                    row.data = [];

                    for (let day = 0; day < 7; day++) {
                        let visitsData = (_.find(this.getVisitsData, { 'hour': hour, 'day': day }));
                        if (_.isEmpty(visitsData)) {
                            row.data.push({
                                x: this.days[day],
                                y: 0
                            });
                        } else {
                            row.data.push({
                                x: this.days[day],
                                y: visitsData.visits
                            });
                        }
                    }

                    this.series.push(row);
                }
            },
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