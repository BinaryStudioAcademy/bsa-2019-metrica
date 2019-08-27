<template>
    <VContainer>
        <div class="d-flex justify-content-between">
            <div>chart</div>
            <ActiveVisitorsCard
                :data="activityDataItems"
                :is-fetching="activityDataFetching"
                :activity-chart-data="activityChartData"
            />
        </div>
        <DevicesPieChart
            :data="devicesPieData"
            :legend="devicesLegend"
            :is-fetching="devicesPieData.isFetching"
        />
    </VContainer>
</template>
<script>
    import { isWebsite } from "@/mixins/isWebsite";
    import DevicesPieChart from "@/components/widgets/DevicesPieChart.vue";
    import ActiveVisitorsCard from "../components/dashboard/home/ActiveVisitorsCard";
    import {mapGetters, mapActions} from 'vuex';
    import {
        GET_ACTIVITY_DATA_ITEMS,
        GET_ACTIVITY_DATA_FETCHING,
        GET_ACTIVITY_CHART_DATA,
    } from "../store/modules/dashboard/types/getters";
    import {
        FETCHING_ACTIVITY_CHART_DATA,
        FETCHING_ACTIVITY_DATA_ITEMS,
    } from "../store/modules/dashboard/types/actions";

    export default {
        name: 'Dashboard',
        components: {
            DevicesPieChart,
            ActiveVisitorsCard,
        },
        mixins: [isWebsite],
        created() {
            this.fetchingActivityDataItems();
            this.fetchingActivityChartData();
        },
        computed: {
            title () {
                return this.$route.meta.title;
            },
            ...mapGetters('dashboard', {
                activityDataItems: GET_ACTIVITY_DATA_ITEMS,
                activityDataFetching: GET_ACTIVITY_DATA_FETCHING,
                activityChartData: GET_ACTIVITY_CHART_DATA,
            }),
        },
        methods: {
            ...mapActions('dashboard', {
                fetchingActivityDataItems: FETCHING_ACTIVITY_DATA_ITEMS,
                fetchingActivityChartData: FETCHING_ACTIVITY_CHART_DATA,
            }),
        },
        data () {
            return {
                data: [],
                period: '',
                devicesPieData: {
                    system: [
                        ['Type', 'Value'],
                        ['Mac  ', 25],
                        ['Windows', 65],
                        ['Others', 10],
                    ],
                    device: [
                        ['Type', 'Value'],
                        ['Desktop', 25],
                        ['Mobile', 65],
                        ['Tablet', 10],
                    ],
                    isFetching: false,
                },
                devicesLegend: {
                    system: {
                        title: 'System',
                        data: {
                            mac: {
                                title: 'Mac',
                                percentageDiff: 25,
                                color: '#3C57DE',
                            },
                            windows: {
                                title: 'Windows',
                                percentageDiff: 65,
                                color: '#1BC3DA',
                            },
                            others: {
                                title: 'Others',
                                percentageDiff: 10,
                                color: '#67C208',
                            },
                        }
                    },
                    device: {
                        title: 'Device',
                        data: {
                            desktop: {
                                title: 'Desktop',
                                percentageDiff: 25,
                                color: '#F03357',
                            },
                            mobile: {
                                title: 'Mobile',
                                percentageDiff: 65,
                                color: '#ff9900',
                            },
                            tablet: {
                                title: 'Tablet',
                                percentageDiff: 10,
                                color: '#FFD954',
                            },
                        }
                    },
                },
            };
        },
    };
</script>
