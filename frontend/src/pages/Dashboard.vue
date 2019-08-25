<template>
    <ContentLayout
        :title="title"
    >
        <div class="d-flex justify-content-between">
            <div>chart</div>
            <ActiveVisitorsCard
                :data="activityDataItems"
                :is-fetching="activityDataFetching"
                :activity-chart-data="activityChartData"
            />
        </div>
    </ContentLayout>
</template>
<script>
    import { isWebsite } from "@/mixins/isWebsite";
    import ActiveVisitorsCard from "../components/dashboard/home/ActiveVisitorsCard";
    import ContentLayout from "@/components/layout/ContentLayout";
    import {mapGetters, mapActions} from 'vuex';
    import {
        GET_ACTIVITY_DATA_ITEMS,
        GET_ACTIVITY_DATA_FETCHING,
        GET_ACTIVITY_CHART_DATA
    } from "../store/modules/dashboard/types/getters";
    import {FETCHING_ACTIVITY_CHART_DATA, FETCHING_ACTIVITY_DATA_ITEMS} from "../store/modules/dashboard/types/actions";
    export default {
        name: 'Dashboard',
        components: { ContentLayout, ActiveVisitorsCard },
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
        }
    };
</script>
