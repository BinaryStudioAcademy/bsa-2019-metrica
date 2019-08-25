<template>
    <DevicesPieChart
        :data="devicesPieData"
        :legend="devicesLegend"
        :is-fetching="devicesPieData.isFetching"
    />
</template>
<script>
    import { isWebsite } from "@/mixins/isWebsite";
    import DevicesPieChart from "@/components/widgets/DevicesPieChart.vue";

    export default {
        name: 'Dashboard',
        components: {
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
                    isFetching: false,
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
                },
            };
        },
    };
</script>