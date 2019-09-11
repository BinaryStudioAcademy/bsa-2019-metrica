<template>
    <ContentLayout :title="title">
        <VRow class="mb-5">
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
                :error-items="getTableDataItems()"
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
    import moment from 'moment';
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
        GET_FORMAT_LINE_CHART_DATA,
        GET_TABLE_DATA
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
            };
        },
        computed: {
            ...mapGetters('error_report', {
                getSelectedPeriod: GET_SELECTED_PERIOD,
                chartData: GET_LINE_CHART_DATA,
                tableData: GET_TABLE_DATA,
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
            getTableDataItems () {
                return this.tableData.items.map((item) => {
                    return {...item, max_created: moment.utc(item.max_created).format('llll')};
                });
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
