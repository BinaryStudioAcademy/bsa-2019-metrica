<template>
    <ContentLayout :title="title">
        <VRow>
            <VContainer class="white card px-7 py-6">
                <LineChart
                    :data="formatLineChartData"
                    :is-fetching="chartData.isFetching"
                    :units="units"
                />
                <PeriodDropdown
                    :value="getSelectedPeriod"
                    @change="changePeriod"
                />
            </VContainer>
        </VRow>
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
        <VRow>
            <VCol
                lg="7"
                sm="12"
            >
                <VisitorsTable />
            </VCol>
            <VCol
                lg="5"
                sm="12"
            >
                <PieChart
                    :chart-data="pieData"
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
        GET_FORMAT_LINE_CHART_DATA
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

            };
        },
        computed: {
            ...mapGetters('visitors', {
                buttonsData: GET_BUTTON_DATA,
                currentActiveButton: GET_ACTIVE_BUTTON,
                getSelectedPeriod: GET_SELECTED_PERIOD,
                pieChartData: GET_PIE_CHART_DATA,
                chartData: GET_LINE_CHART_DATA,
                formatLineChartData:GET_FORMAT_LINE_CHART_DATA,
            }),
            units() {
                return this.currentActiveButton === BOUNCE_RATE ? '%' : '';
            },
            pieData () {
                return [
                    ['Type', 'Value'],
                    ['New Visitors', this.pieChartData.newVisitors],
                    ['Returning Visitors',this.pieChartData.returningVisitors]
                ];
            },
            legend () {
                return {
                    title: 'Outcome',
                    data: {
                        newVisitors: {
                            title: 'New Visitors',
                            percentageDiff: Number(this.pieChartData.newVisitors),
                            color: '#3C57DE',
                        },
                        returningVisitors: {
                            title: 'Returning Visitors',
                            percentageDiff: Number(this.pieChartData.returningVisitors),
                            color: '#1BC3DA',
                        },
                    }
                };
            },
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
            isButtonActive (type) {
                return this.currentActiveButton === type;
            },
            getButtonValue (type) {
                if (type === 'avg_session') {
                    const duration = moment.duration(parseInt(this.buttonsData[type].value), 's');
                    const hours = Math.floor(duration.asHours());
                    const minutes = moment.utc(duration.asMilliseconds()).format("mm:ss");
                    return `${hours}:${minutes}`;
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
    .card {
        border-radius: 6px;
        box-shadow: 0px 0px 28px rgba(194, 205, 223, 0.7);
    }
    .buttons-row {
        margin-top: 50px;
    }
    @media (max-width: 1263px) {
        .piechart {
            margin: 0;
        }
    }
</style>
