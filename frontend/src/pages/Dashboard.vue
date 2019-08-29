<template>
    <ContentLayout :title="title">
        <VRow>
            <VCol class="pl-0 pr-2">
                <Overview />
            </VCol>
            <VCol class="cl">
                <ActiveVisitorsCard
                    :is-fetching="activityDataFetching"
                    :activity-chart-data="activityChartData"
                />
            </VCol>
        </VRow>
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
    export default {
        name: 'Dashboard',
        components: { ContentLayout, ActiveVisitorsCard, Overview },
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

<style>
    .cl {
        padding-left: 0;
        padding-right: 0;
        max-width: 307px;
    }
</style>
