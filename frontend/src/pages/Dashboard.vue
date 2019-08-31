<template>
    <ContentLayout :title="title">
        <VRow>
            <VCol class="pl-0 pr-2">
                <Overview />
            </VCol>
            <VCol class="widget px-0 mr-2">
                <ActiveVisitorsCard
                    :is-fetching="activityDataFetching"
                    :activity-chart-data="activityChartData"
                />
            </VCol>
            <VCol class="widget pl-0">
                <DevicesPieChart />
            </VCol>
        </VRow>
        <VRow>
            <VCol class="widget px-0 mr-2">
                <VisitsDensityWidget />
            </VCol>
        </VRow>
    </ContentLayout>
</template>
<script>
    import { isWebsite } from "@/mixins/isWebsite";
    import DevicesPieChart from "@/components/widgets/DevicesPieChart.vue";
    import ActiveVisitorsCard from "../components/dashboard/home/ActiveVisitorsCard";
    import ContentLayout from "@/components/layout/ContentLayout";
    import Overview from "@/components/dashboard/dashboard/Overview";
    import {mapGetters, mapActions} from 'vuex';
    import {
        GET_ACTIVITY_DATA_FETCHING,
        GET_ACTIVITY_CHART_DATA,
    } from "../store/modules/dashboard/types/getters";
    import {
        FETCHING_ACTIVITY_CHART_DATA,
    } from "../store/modules/dashboard/types/actions";
    import VisitsDensityWidget from '@/components/dashboard/home/VisitsDensityWidget';

    export default {
        name: 'Dashboard',
        components: {
            DevicesPieChart,
            ActiveVisitorsCard,
            ContentLayout,
            Overview,
            VisitsDensityWidget
        },
        mixins: [isWebsite],
        created() {
            this.fetchingActivityChartData();
        },
        computed: {
            title () {
                return this.$route.meta.title;
            },
            ...mapGetters('dashboard', {
                activityDataFetching: GET_ACTIVITY_DATA_FETCHING,
                activityChartData: GET_ACTIVITY_CHART_DATA,
            })
        },
        methods: {
            ...mapActions('dashboard', {
                fetchingActivityChartData: FETCHING_ACTIVITY_CHART_DATA,
            }),
        },
        data () {
            return {
                data: [],
                period: '',
            };
        },
    };
</script>

<style>
    .widget {
        max-width: 307px;
    }
</style>
