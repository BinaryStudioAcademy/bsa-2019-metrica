<template>
    <ContentLayout :title="title">
        <VRow>
            <VContainer class="white card px-7 py-6">
                <LineChart
                    :data="formatLineChartData"
                    :is-fetching="chartData.isFetching"
                />
                <PeriodDropdown
                    :value="getSelectedPeriod"
                    @change="changePeriod"
                />
            </VContainer>
        </VRow>
        <VRow class="position-relative">
            <Spinner v-if="fetching" />
            <ErrorsTable
                :error-items="tableData.items"
                :fetching="tableData.isFetching"
                @change="changeGroupedParameter"
            />
        </VRow>
    </ContentLayout>
</template>

<script>
    import ContentLayout from '../../components/layout/ContentLayout.vue';
    import LineChart from "../../components/common/LineChart";
    import ErrorsTable from '../../components/dashboard/errors/ErrorsTable.vue';
    import { isWebsite } from "../../mixins/isWebsite";
    import PeriodDropdown from "../../components/dashboard/common/PeriodDropdown.vue";
    import Spinner from '../../components/utilites/Spinner';
    import {mapGetters, mapActions} from 'vuex';
    import {
        GET_SELECTED_PERIOD,
        GET_LINE_CHART_DATA,
        GET_FORMAT_LINE_CHART_DATA
    } from "@/store/modules/error_report/types/getters";
    import {
        CHANGE_FETCHED_BUTTON_STATE,
        CHANGE_SELECTED_PERIOD,
        FETCH_PAGE_DATA
    } from "@/store/modules/error_report/types/actions";

    export default {
        name: "ErrorReports",
        components: {
            ContentLayout,
            ErrorsTable,
            Spinner,
            LineChart,
            PeriodDropdown

        },
        mixins: [isWebsite],
        data() {
            return {
                title: "Error Reports",
                current_paremeter: 'page',
                tableData: {
                    isFetching: false,
                    items: [
                        {
                            parameter_value: '/contacts',
                            page: '/contacts',
                            message: 'SyntaxError',
                            page_views: 45
                        },
                        {
                            parameter_value: '/home',
                            page: '/home',
                            message: 'ReferenceError',
                            page_views: 34
                        },
                        {
                            parameter_value: '/products',
                            page: '/products',
                            message: 'TypeError',
                            page_views: 12
                        },
                        {
                            parameter_value: '/user',
                            page: '/user',
                            message: 'InternalError',
                            page_views: 3
                        }
                    ]
                }
            };
        },
        computed: {
            ...mapGetters('error_report', {
                getSelectedPeriod: GET_SELECTED_PERIOD,
                chartData: GET_LINE_CHART_DATA,
                formatLineChartData:GET_FORMAT_LINE_CHART_DATA,
            }),
        },
        created () {
            this.fetchPageData();
        },
        methods: {
            changeGroupedParameter (parameter) {
                if (this.currentParameter !== parameter) {
                    this.currentParameter = parameter;
                }
            },
            ...mapActions('visitors', {
                changeFetchingButtonState: CHANGE_FETCHED_BUTTON_STATE,
                changeSelectedPeriod: CHANGE_SELECTED_PERIOD,
                fetchPageData: FETCH_PAGE_DATA
            }),
            changePeriod (data) {
                this.changeSelectedPeriod(data);
            },
        }
    };
</script>

<style scoped>

</style>
