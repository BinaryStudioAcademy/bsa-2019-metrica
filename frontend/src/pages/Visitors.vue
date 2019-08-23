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
                            :data="data"
                            :is-fetching="chartData.isFetching"
                        />
                        <PeriodDropdown
                            :value="getSelectedPeriod"
                            @change="changePeriod"
                        />
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
                    :active="isActive"
                    :fetching="buttonsData[button.type].isFetching"
                    :value="buttonsData[button.type].value"
                    :type="button.type"
                    :icon-name="button.icon"
                    @change="changeButton"
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
    import ContentLayout from '../components/layout/ContentLayout.vue';
    import LineChart from "../components/common/LineChart";
    import VisitorsTable from "../components/dashboard/visitors/VisitorsTable.vue";
    import ButtonComponent from "../components/dashboard/common/ButtonComponent.vue";
    import PeriodDropdown from "../components/dashboard/common/PeriodDropdown.vue";
    import PieChart from "../components/common/PieChart";
    import {mapGetters, mapActions} from 'vuex';
    import {
        GET_BUTTON_DATA,
        GET_ACTIVE_BUTTON,
        GET_SELECTED_PERIOD,
        GET_PIE_CHART_DATA,
        GET_LINE_CHART_DATA
    } from "@/store/modules/visitors/types/getters";
    import {
        CHANGE_ACTIVE_BUTTON,
        CHANGE_FETCHED_BUTTON_STATE,
        CHANGE_SELECTED_PERIOD
    } from "@/store/modules/visitors/types/actions";
    import {
        TOTAL_VISITORS,
        NEW_VISITORS,
        AVG_SESSION,
        PAGE_VIEWS,
        SESSIONS,
        BOUNCE_RATE
    } from '../configs/visitors/buttonTypes.js';

    export default {
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
                data: [],
                period: '',
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
                pieData: [
                    ['Type', 'Value'],
                    ['New Visitors', this.getPieData.newVisitors],
                    ['Return Visitors',this.getPieData.returnVisitors],
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
            title () {
                return this.$route.meta.title;
            },
            tableData () {
                return this.items;
            },
            ...mapGetters('visitors', {
                buttonsData: GET_BUTTON_DATA,
                currentActiveButton: GET_ACTIVE_BUTTON,
                getSelectedPeriod: GET_SELECTED_PERIOD,
                pieChartData: GET_PIE_CHART_DATA,
                chartData: GET_LINE_CHART_DATA,
            }),
            isActive () {
                return this.currentActiveButton === this.type;
            },
            buttonData () {
                return this.buttonsData[this.type];
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
                this.data.push(item);
            }
        },
        methods: {
            ...mapActions('visitors', {
                changeActiveButton: CHANGE_ACTIVE_BUTTON,
                changeFetchingButtonState: CHANGE_FETCHED_BUTTON_STATE,
                changeSelectedPeriod: CHANGE_SELECTED_PERIOD
            }),
            changeButton (data) {
                this.changeActiveButton(data);
            },
            changeTable (parameter) {
                this.items = this.tableItems[parameter];
            },
            changePeriod(data) {
                this.changeSelectedPeriod(data);
            },
            getPieData(){
                return this.pieChartData;
            }
        },
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
