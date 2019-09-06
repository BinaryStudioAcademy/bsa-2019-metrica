<template>
    <div>
        <div class="subtitle-1 pl-1 pb-4 grey--text text--darken-1">
            Times
        </div>
        <div class="white visits-widget text-dark d-flex flex-column justify-space-between">
            <Spinner
                v-if="isFetching"
            />
            <div class="ml10">
                Users by time of day
            </div>
            <VueApexCharts
                type="heatmap"
                height="350px"
                :options="chartOptions"
                :series="drawHeatmap"
                class="visits-heatmap"
            />
            <VisitsDensityPeriodDropdown
                class="ml10"
                :value="getSelectedPeriod"
                @change="changeSelectedPeriod"
            />
        </div>
    </div>
</template>

<script>
    import VueApexCharts from 'vue-apexcharts';
    import VisitsDensityPeriodDropdown from "@/components/dashboard/common/VisitsDensityPeriodDropdown";
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

    export default {
        name: "VisitsDensityWidget",
        components: {
            VueApexCharts,
            VisitsDensityPeriodDropdown,
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
                            align: 'right',
                            offsetX: 10
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
            drawHeatmap () {
                let series = [];

                for (let hour = 0; hour < 24; hour++) {
                    let row = {};
                    row.name = this.hours[hour] || '';
                    row.data = [];

                    for (let day = 0; day < 7; day++) {
                        let visitsData = this.getVisitsData.find((item) => {
                            return item.hour === hour && item.day === day;
                        });
                        if (visitsData) {
                            row.data.push({
                                x: this.days[day],
                                y: visitsData.visits
                            });
                        } else {
                            row.data.push({
                                x: this.days[day],
                                y: 0
                            });
                        }
                    }

                    series.push(row);
                }

                return series;
            }
        },
        created() {
            this.fetchWidgetData();
        },
        methods: {
            ...mapActions('visits_density_widget', {
                changeSelectedPeriod: CHANGE_SELECTED_PERIOD,
                fetchWidgetData: FETCH_WIDGET_DATA
            })
        }
    };
</script>

<style scoped>
    .visits-widget {
        border: none;
        box-shadow: 0px 0px 28px rgba(194, 205, 223, 0.7);
        border-radius: 6px;
        padding: 1.5rem;
        width: 352px;
        height: 480px;
    }

    .ml10 {
        margin-left: 10px;
    }

    .visits-heatmap {
        margin-top: -.5rem;
        margin-right: -2rem;
    }
</style>