<template>
    <ContentLayout :title="title">
        <VRow>
            <VCol class="pl-0 pr-2">
                <Overview />
            </VCol>
            <VCol class="widget px-0 mr-2">
                <ActiveVisitorsCard />
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
        computed: {
            title () {
                return this.$route.meta.title;
            },
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
