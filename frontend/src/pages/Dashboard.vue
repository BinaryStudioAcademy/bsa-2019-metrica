<template>
    <ContentLayout :title="title">
        <Overview />
        <div class="d-flex justify-content-between">
            <div>chart</div>
            <ActiveVisitorsCard
                :is-fetching="activityDataFetching"
                :activity-chart-data="activityChartData"
            />
        </div>
        <div class="d-flex justify-content-between">
            <VisitsDensityWidget />
        </div>
    </ContentLayout>
</template>
<script>
    import { isWebsite } from "@/mixins/isWebsite";
    import ActiveVisitorsCard from "../components/dashboard/home/ActiveVisitorsCard";
    import ContentLayout from "@/components/layout/ContentLayout";
    import Overview from "@/components/dashboard/dashboard/Overview";
    import {mapGetters, mapActions} from 'vuex';
    import {
        GET_ACTIVITY_DATA_FETCHING,
        GET_ACTIVITY_CHART_DATA
    } from "../store/modules/dashboard/types/getters";
    import {
        FETCHING_ACTIVITY_CHART_DATA,
    } from "../store/modules/dashboard/types/actions";
    import VisitsDensityWidget from '@/components/dashboard/home/VisitsDensityWidget';

    export default {
        name: 'Dashboard',
        components: {
            ContentLayout,
            ActiveVisitorsCard,
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
        }
    };
</script>
