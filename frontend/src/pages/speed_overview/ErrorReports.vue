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
            <Spinner v-if="tableData.isFetching" />
            <ErrorsTable
                @open="openModal"
                :error-items="tableData.items"
                @change="changeGroupedParameter"
            />
        </VRow>
        <ErrorsDetailsModal
            :dialog="dialog"
            :error-item="modalItem"
            @close="dialog = false"
        />
    </ContentLayout>
</template>

<script>
    import ContentLayout from '../../components/layout/ContentLayout.vue';
    import LineChart from "../../components/common/LineChart";
    import ErrorsTable from '../../components/dashboard/errors/ErrorsTable.vue';
    import { isWebsite } from "../../mixins/isWebsite";
    import PeriodDropdown from "../../components/dashboard/common/PeriodDropdown.vue";
    import Spinner from '../../components/utilites/Spinner';
    import ErrorsDetailsModal from '../../components/dashboard/errors/ErrorsDetailsModal';

    import {mapGetters, mapActions} from 'vuex';
    import {
        GET_SELECTED_PERIOD,
        GET_LINE_CHART_DATA,
        GET_FORMAT_LINE_CHART_DATA
    } from "@/store/modules/error_report/types/getters";
    import {
        CHANGE_SELECTED_PERIOD,
        FETCH_PAGE_DATA
    } from "@/store/modules/error_report/types/actions";

    export default {
        name: "ErrorReports",
        components: {
            ContentLayout,
            ErrorsDetailsModal,
            ErrorsTable,
            Spinner,
            LineChart,
            PeriodDropdown

        },
        mixins: [isWebsite],
        data() {
            return {
                dialog:false,
                modalItem:{
                    message: 'message'
                },
                title: "Error Reports",
                current_paremeter: 'page',
                tableData: {
                    isFetching: false,
                    items: [
                        {
                            parameter_value: '/contacts',
                            page: '/contacts',
                            message: 'SyntaxError',
                            stack_trasce: 'at Object.device.tablet (metrica.js?tracking_id=00000186:317)\n' +
                                'at Object.device.desktop (metrica.js?tracking_id=00000186:325)\n' +
                                'at Object.getDevice (metrica.js?tracking_id=00000186:130)',
                            page_views: 45
                        },
                        {
                            parameter_value: '/home',
                            page: '/home',
                            message: 'ReferenceError',
                            stack_trace: 'at Object.device.tablet (metrica.js?tracking_id=00000186:317)\n' +
                                'at Object.device.desktop (metrica.js?tracking_id=00000186:325)\n' +
                                'at Object.getDevice (metrica.js?tracking_id=00000186:130)',
                            page_views: 34
                        },
                        {
                            parameter_value: '/products',
                            page: '/products',
                            message: 'TypeError',
                            stack_trace: 'at Object.device.tablet (metrica.js?tracking_id=00000186:317)\n' +
                                'at Object.device.desktop (metrica.js?tracking_id=00000186:325)\n' +
                                'at Object.getDevice (metrica.js?tracking_id=00000186:130)',
                            page_views: 12
                        },
                        {
                            parameter_value: '/user',
                            page: '/user',
                            message: 'InternalError',
                            stack_trace: 'at Object.device.tablet (metrica.js?tracking_id=00000186:317)\n' +
                                'at Object.device.desktop (metrica.js?tracking_id=00000186:325)\n' +
                                'at Object.getDevice (metrica.js?tracking_id=00000186:130)',
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
            ...mapActions('error_report', {
                changeSelectedPeriod: CHANGE_SELECTED_PERIOD,
                fetchPageData: FETCH_PAGE_DATA
            }),
            changeGroupedParameter (parameter) {
                if (this.currentParameter !== parameter) {
                    this.currentParameter = parameter;
                }
            },
            changePeriod (data) {
                this.changeSelectedPeriod(data);
            },
            openModal(item) {
                this.dialog = true;
                this.modalItem = {
                    ...this.modalItem,
                    ...item
                };
            }
        }
    };
</script>

<style scoped>

</style>
