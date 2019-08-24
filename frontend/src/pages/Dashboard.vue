<template>
    <ContentLayout :title="title">
        <VLayout
            wrap
        />
        <VLayout>
            <VFlex
                lg6
                md6
                hidden-sm-and-down
                height="100%"
                class="img-card"
            >
                <VisitorsTable />
            </VFlex>
            <VFlex
                lg5
                md5
                hidden-sm-and-down
                height="100%"
                class="img-card"
            >
                <DevicesPieChart
                    :data="devicesPieData"
                    :legend="devicesLegend"
                    :is-fetching="devicesPieData.isFetching"
                />
            </VFlex>
        </VLayout>
    </ContentLayout>
</template>
<script>
    import { isWebsite } from "@/mixins/isWebsite";
    import ContentLayout from "@/components/layout/ContentLayout";
    import DevicesPieChart from "@/components/widgets/DevicesPieChart.vue";

    export default {
        name: 'Dashboard',
        components: {
            ContentLayout,
            DevicesPieChart,
        },
        mixins: [isWebsite],
        computed: {
            title () {
                return this.$route.meta.title;
            }
        },
        data () {
            return {
                devicesPieData: [
                    ['Type', 'Value'],
                    ['New Visitors', 41],
                    ['Return Visitors', 49],
                ],
                devicesLegend: {
                    title: 'Outcome',
                    data: {
                        newVisitors: {
                            title: 'New Visitors',
                            percentageDiff: 41,
                            color: '#3C57DE',
                        },
                        returnVisitors: {
                            title: 'Return Visitors',
                            percentageDiff: 49,
                            color: '#1BC3DA',
                        },
                    }
                }
            };
        },
    };
</script>