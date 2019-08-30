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
                        class="chart-container position-relative"
                    >
                        <LineChart
                            :data="chartData.items"
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
        <VRow
            class="buttons-row justify-sm-center justify-lg-start justify-xl-space-between "
        >
            <ButtonComponent
                v-for="button in buttons"
                :key="button.title"
                :title="button.title"
                :active="isButtonActive(button.type)"
                :fetching="buttonsData[button.type].isFetching"
                :value="getButtonValue(button.type)"
                :type="button.type"
                :icon-name="button.icon"
                @change="changeButton"
            />
        </VRow>
        <VRow
            flex
            wrap
        >
            <VCol
                lg6
                md-8
                sm12
                height="100%"
                class="img-card"
            >
                <VisitorsTable />
            </VCol>
            <VCol
                lg6
                md5
                sm12
                height="100%"
                class="img-card"
            >
                <PieChart
                    :data="pieData"
                    :legend="legend"
                    :is-fetching="pieChartData.isFetching"
                />
            </VCol>
        </VRow>
    </ContentLayout>
</template>

<script>
    import moment from 'moment';
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
        GET_LINE_CHART_DATA,
    } from "@/store/modules/visitors/types/getters";
    import {
        CHANGE_ACTIVE_BUTTON,
        CHANGE_FETCHED_BUTTON_STATE,
        CHANGE_SELECTED_PERIOD,
        FETCH_PAGE_DATA
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
                title: "Visitors",
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
            ...mapGetters('visitors', {
                buttonsData: GET_BUTTON_DATA,
                currentActiveButton: GET_ACTIVE_BUTTON,
                getSelectedPeriod: GET_SELECTED_PERIOD,
                pieChartData: GET_PIE_CHART_DATA,
                chartData: GET_LINE_CHART_DATA,
            }),
        },
        created () {
            this.fetchPageData();
        },
        methods: {
            ...mapActions('visitors', {
                changeActiveButton: CHANGE_ACTIVE_BUTTON,
                changeFetchingButtonState: CHANGE_FETCHED_BUTTON_STATE,
                changeSelectedPeriod: CHANGE_SELECTED_PERIOD,
                fetchPageData: FETCH_PAGE_DATA
            }),
            changeButton (data) {
                this.changeActiveButton(data);
            },
            changePeriod (data) {
                this.changeSelectedPeriod(data);
            },
            getPieData(){
                return this.pieChartData;
            },
            isButtonActive (type) {
                return this.currentActiveButton === type;
            },
            getButtonValue (type) {
                if (type === 'avg_session') {
                    return moment.unix(this.buttonsData[type].value).format("HH:mm:ss");
                }

                if (type === 'bounce_rate') {
                    return Math.round(Number(this.buttonsData[type].value)) + '%';
                }
                return this.buttonsData[type].value;
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
