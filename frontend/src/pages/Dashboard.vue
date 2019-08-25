<template>
    <ContentLayout
        :title="title"
    >
        <div class="d-flex justify-content-between">
            <div>chart</div>
            <ActiveVisitorsCard
                :data="activityData"
                :is-fetching="isFetching"
            />
        </div>
    </ContentLayout>
</template>
<script>
    import { isWebsite } from "@/mixins/isWebsite";
    import ActiveVisitorsCard from "../components/dashboard/home/ActiveVisitorsCard";
    import ContentLayout from "@/components/layout/ContentLayout";
    import {mapGetters, mapActions} from 'vuex';
    import {GET_ACTIVITY_DATA_ITEMS, GET_ACTIVITY_DATA_FETCHING} from "../store/modules/dashboard/types/getters";
    import {CHANGE_ACTIVITY_DATA_ITEMS} from "../store/modules/dashboard/types/actions";
    export default {
        name: 'Dashboard',
        components: { ContentLayout, ActiveVisitorsCard },
        mixins: [isWebsite],
        data() {
            return {
                activityData: [],
                isFetching: false
            };
        },
        computed: {
            title () {
                return this.$route.meta.title;
            },
            ...mapGetters('dashboard', {
                getActivityDataItems: GET_ACTIVITY_DATA_ITEMS,
                getActivityDataFetching: GET_ACTIVITY_DATA_FETCHING,
            }),
        },
        methods: {
            ...mapActions('dashboard', {
                changeActivityDataItems: CHANGE_ACTIVITY_DATA_ITEMS,
            }),
        }
    };
</script>
