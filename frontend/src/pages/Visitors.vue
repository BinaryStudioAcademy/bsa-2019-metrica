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
                    :character="button.character"
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
                <GroupedTable
                    :items="tableData"
                    @change="changeTable"
                />
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
                />
            </VFlex>
        </VLayout>
    </ContentLayout>
</template>

<script>
    import ContentLayout from '../components/layout/ContentLayout.vue';
    import LineChart from "../components/common/LineChart";
    import GroupedTable from "../components/dashboard/visitors/GroupedTable";
    import ButtonComponent from "../components/dashboard/visitors/ButtonComponent";
    import PeriodDropdown from "../components/dashboard/visitors/PeriodDropdown";
    import PieChart from "../components/common/PieChart";
    import {isWebsite} from '../mixins/isWebsite';

    export default {
        mixins: [isWebsite],
        components: {
            PieChart,
            LineChart,
            GroupedTable,
            ButtonComponent,
            PeriodDropdown,
            ContentLayout
        },
        data() {
            return {
                chartData: {
                    items: [],
                    isFetching: false
                },
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
                        character: '120'
                    },
                    {
                        icon: 'eye',
                        title: 'New visitors',
                        character: '100'
                    },
                    {
                        icon: 'clock',
                        title: 'Avg. session',
                        character: '00:00:33'
                    },
                    {
                        icon: 'yellow_arrow',
                        title: 'Page views',
                        character: '321'
                    },
                    {
                        icon: 'peach_arrow',
                        title: 'Sessions',
                        character: '145'
                    },
                    {
                        icon: 'violet_arrow',
                        title: 'Bounce rate',
                        character: '41%'
                    },
                ],
                pieData: [
                    ['Type', 'Value'],
                    ['New Visitors', 41],
                    ['Return Visitors', 59],
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
                tableItems: {
                    'language': [
                        {
                            option: 'us',
                            users: 67,
                            percentage: '50%'
                        },
                        {
                            option: 'en',
                            users: 67,
                            percentage: '50%'
                        },
                        {
                            option: 'fr',
                            users: 67,
                            percentage: '50%'
                        }
                    ],
                    'browser': [
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
                        {
                            option: 'Chrome',
                            users: 84,
                            percentage: '34%'
                        },
                        {
                            option: 'iOS Safari',
                            users: 44,
                            percentage: '55%'
                        }]
                }
            };
        },
        computed: {
            title () {
                return this.$route.meta.title;
            },
            tableData () {
                return this.items;
            }
        },
        mounted() {
            for (let i = 1; i < 20; i++) {
                const x = new Date(2019, 9, 5, i).toLocaleTimeString();
                const item = {
                    xLabel: x,
                    value: Math.floor(Math.random() * 2000) + 1,
                    indication: Math.floor(Math.random() * 200) + 1,
                };
                this.chartData.items.push(item);
            }
        },
        methods: {
            changeTable (parameter) {
                this.items = this.tableItems[parameter];
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
