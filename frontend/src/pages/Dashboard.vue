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
            />
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
                data: [],
                period: '',
                devicesPieData: {
                    system: [
                        ['Type', 'Value'],
                        ['New Visitors', 20],
                        ['Return Visitors', 60],
                    ],
                    device: [
                        ['Type', 'Value'],
                        ['New Visitors', 30],
                        ['Return Visitors', 50],
                    ],
                    isFetching: true,
                },
                devicesLegend: {
                    system: {
                        title: 'System',
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
                    },
                    device: {
                        title: 'Device',
                        data: {
                            newVisitors: {
                                title: 'New Visitors',
                                percentageDiff: 41,
                                color: '#F03357',
                            },
                            returnVisitors: {
                                title: 'Return Visitors',
                                percentageDiff: 49,
                                color: '#FFD954',
                            },
                        }
                    },
                }
            };
        },
    };
</script>