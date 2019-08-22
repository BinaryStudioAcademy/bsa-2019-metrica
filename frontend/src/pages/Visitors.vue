<template>
    <ContentLayout :title="title">
        <VLayout
            wrap
        />
        <VLayout>
            <VFlex
                lg12
                md12
                sm12
                xs12
                class="content-card"
            >
                <VLayout
                    wrap
                    align-center
                    justify-center
                >
                    <VFlex
                        class="chart-container"
                    >
                        <LineChart
                            :data="chartData.items"
                            :is-fetching="chartData.isFetching"
                        />
                        <PeriodDropdown />
                    </VFlex>
                </VLayout>
            </VFlex>
        </VLayout>
        <VLayout class="buttons-row">
            <VFlex
                v-for="button in buttons"
                :key="button.title"
            >
                <ButtonComponent
                    :title="button.title"
                    :type="button.type"
                    :icon-name="button.icon"
                />
            </VFlex>
        </VLayout>
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
                <PieChart
                    :data="pieData"
                    :legend="legend"
                    :is-fetching="pieChartData.isFetching"
                />
            </VFlex>
        </VLayout>
    </ContentLayout>
</template>

<script>
    import {mapGetters} from 'vuex';
    import {
        GET_PIE_CHART_DATA,
        GET_LINE_CHART_ITEMS,
    } from "@/store/modules/visitors/types/getters";
    import ContentLayout from '../components/layout/ContentLayout.vue';
    import LineChart from "../components/common/LineChart";
    import VisitorsTable from "../components/dashboard/visitors/VisitorsTable";
    import ButtonComponent from "../components/dashboard/visitors/ButtonComponent";
    import PeriodDropdown from "../components/dashboard/visitors/PeriodDropdown";
    import PieChart from "../components/common/PieChart";
    import {isWebsite} from '../mixins/isWebsite';
    import {
        TOTAL_VISITORS,
        NEW_VISITORS,
        AVG_SESSION,
        PAGE_VIEWS,
        SESSIONS,
        BOUNCE_RATE
    } from '../configs/visitors/buttonTypes.js';

    export default {
        mixins: [isWebsite],
        components: {
            PieChart,
            LineChart,
            VisitorsTable,
            ButtonComponent,
            PeriodDropdown,
            ContentLayout
        },
        data() {
            return {
                items: [
                    {
                        option: 'IE',
                        users: 55,
                        percentage: '34%'
                    },
                    {
                        option: 'Edge',
                        users: 77,
                        percentage: '34%'
                    },
                    {
                        option: 'Firefox',
                        users: 45,
                        percentage: '44%'
                    },
                ],
                buttons: [
                    {
                        icon: 'person',
                        title: 'Total visitors',
                        type: TOTAL_VISITORS
                    },
                    {
                        icon: 'eye',
                        title: 'New visitors',
                        type: NEW_VISITORS
                    },
                    {
                        icon: 'clock',
                        title: 'Avg. session',
                        type: AVG_SESSION
                    },
                    {
                        icon: 'yellow_arrow',
                        title: 'Page views',
                        type: PAGE_VIEWS
                    },
                    {
                        icon: 'peach_arrow',
                        title: 'Sessions',
                        type: SESSIONS
                    },
                    {
                        icon: 'violet_arrow',
                        title: 'Bounce rate',
                        type: BOUNCE_RATE
                    },
                ],
                legend: {
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
                },
            };
        },
        computed: {
            ...mapGetters('visitors', {
                pieChartData: GET_PIE_CHART_DATA,
                chartData: GET_LINE_CHART_ITEMS,
            }),
            title () {
                return this.$route.meta.title;
            },
            pieData () {
                return [
                    ['Type', 'Value'],
                    ['New Visitors', this.pieChartData.newVisitors],
                    ['Return Visitors', this.pieChartData.returnVisitors],
                ];
            }
        }
    };
</script>

<style scoped>
    .buttons-row {
        margin-top: 50px;
    }
    .chart-container {
        box-shadow: 0px 0px 28px rgba(194, 205, 223, 0.7);
    }
</style>
