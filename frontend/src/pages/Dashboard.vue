<template>
    <ContentLayout :title="title">
        <VRow>
            <VCol>
                <Overview />
            </VCol>
        </VRow>
        <VRow class="pa-3 d-flex justify-space-between">
            <ActiveVisitorsCard />
            <DevicesPieChart />
            <VisitsDensityWidget />
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
</style>
