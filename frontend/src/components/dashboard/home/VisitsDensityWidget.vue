<template>
    <div class="mt-10">
        <div class="subtitle-1 pl-1 pb-4 grey--text text--darken-1">
            Times
        </div>
        <div class="white visits-widget text-dark d-flex flex-column justify-space-between">
            <Spinner
                v-if="isFetching"
            />
            <div class="ml-2">
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
                chartOptions: {
                    chart: {
                        toolbar: {
                            show: false
                        },
                        fontFamily: 'Gilroy'
                    },
                    colors: ["#0935de"],
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
                            colorScale: {
                                ranges: []
                            }
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
                const visitsData = this.getVisitsData;
                let series = [];

                for (let hour = 0; hour < 24; hour++) {
                    let row = {};
                    if (hour % 2 === 0) {
                        let date = new Date();
                        date.setHours(hour, 0, 0);
                        row.name = date.toTimeString().substring(0, 5);
                    } else {
                        row.name = '';
                    }
                    row.data = [];

                    for (let day = 0; day < 7; day++) {
                        let visitData = visitsData.find((item) => {
                            return item.hour === hour && item.day === day;
                        });
                        if (visitData) {
                            row.data.push({
                                x: this.days[day],
                                y: visitData.visits
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

                this.setShadesRanges();

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
            }),
            setShadesRanges () {
                let ranges = [{
                    from: -1,
                    to: 0,
                    color: "#d0d8eb"
                }];
                let colors = [
                    "#7887de",
                    "#6f80de",
                    "#6579de",
                    "#5c72de",
                    "#536ade",
                    "#536cde",
                    "#4a65de",
                    "#415ede",
                    "#3757de",
                    "#2e50de",
                    "#254ade",
                    "#1b43de",
                    "#123cde",
                    "#0935de",
                ];

                let max = Math.max.apply(Math, this.getVisitsData.map(item => item.visits));
                let min = Math.min.apply(Math, this.getVisitsData.map(item => item.visits));

                let boundary = (max - min) / colors.length;

                for (let i = 0; i < colors.length; i++) {
                    ranges.push({
                        from: i * boundary + 1,
                        to: (i + 1) * boundary,
                        color: colors[i]
                    });
                }

                this.chartOptions = {...this.chartOptions, ...{
                    plotOptions: {
                        heatmap: {
                            colorScale: {
                                ranges: ranges
                            }
                        }
                    },
                }};
            }
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
        height: 580px;
    }

    .visits-heatmap {
        margin-top: -.5rem;
        margin-right: -2rem;
    }
</style>
