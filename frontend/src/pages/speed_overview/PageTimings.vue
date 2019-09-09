<template>
    <ContentLayout :title="title">
        <VRow>
            <VContainer class="white card px-7 py-6">
                <LineChart
                    :data="formatLineChartData"
                    :is-fetching="chartData.isFetching"
                    units="s"
                />
                <PeriodDropdown
                    :value="getSelectedPeriod"
                    @change="changeSelectedPeriod"
                />
            </VContainer>
        </VRow>
        <VRow
            class="buttons-row justify-sm-center justify-lg-start justify-xl-space-between "
        >
            <ButtonComponent
                v-for="(button, key) in buttons"
                :key="key"
                :title="button.title"
                :active="isButtonActive(key)"
                :fetching="buttonsData[key].isFetching"
                :value="getButtonValue(key)"
                :type="key"
                :icon-name="button.icon"
                @change="changeActiveButton"
            >
                <span
                    class="small"
                >s</span>
            </ButtonComponent>
        </VRow>
        <VRow>
            <PageTimingsTable
                @change="changeGroupedParameter"
                :items="tableData.items"
                :label="label"
                :value="getGroupedParameter"
                :fetching="tableData.isFetching"
            />
        </VRow>
    </ContentLayout>
</template>

<script>
    import ContentLayout from '../../components/layout/ContentLayout.vue';
    import PageTimingsTable from "../../components/dashboard/page_timings/PageTimingsTable";
    import LineChart from "../../components/common/LineChart";
    import ButtonComponent from "../../components/dashboard/common/ButtonComponent.vue";
    import PeriodDropdown from "../../components/dashboard/common/PeriodDropdown.vue";
    import {mapGetters, mapActions} from 'vuex';
    import {
        GET_BUTTON_DATA,
        GET_ACTIVE_BUTTON,
        GET_SELECTED_PERIOD,
        GET_LINE_CHART_DATA,
        GET_FORMAT_LINE_CHART_DATA,
        GET_TABLE_DATA,
        GET_GROUPED_PARAMETER
    } from "@/store/modules/page_timings/types/getters";
    import {
        CHANGE_ACTIVE_BUTTON,
        CHANGE_SELECTED_PERIOD,
        FETCH_PAGE_DATA,
        CHANGE_GROUPED_PARAMETER
    } from "@/store/modules/page_timings/types/actions";
    import {
        AVG_PAGE_LOAD_TIME,
        AVG_LOOKUP_TIME,
        AVG_SERVER_RESPONSE_TIME,
    } from '../../configs/page_timings/buttonTypes.js';

    export default {
        name: "PageTimings",
        components: {
            LineChart,
            ButtonComponent,
            PeriodDropdown,
            ContentLayout,
            PageTimingsTable
        },
        data() {
            return {
                title: "Page Timings",
                buttons: {
                    [AVG_PAGE_LOAD_TIME]: {
                        icon: 'yellow_arrow',
                        title: 'Avg. Page Load Time',
                    },
                    [AVG_LOOKUP_TIME]: {
                        icon: 'eye',
                        title: 'Avg. Domain Lookup Time',
                    },
                    [AVG_SERVER_RESPONSE_TIME]: {
                        icon: 'clock',
                        title: 'Avg. Server Response Time',
                    },
                },
            };
        },
        computed: {
            ...mapGetters('page_timings', {
                buttonsData: GET_BUTTON_DATA,
                currentActiveButton: GET_ACTIVE_BUTTON,
                getSelectedPeriod: GET_SELECTED_PERIOD,
                chartData: GET_LINE_CHART_DATA,
                formatLineChartData:GET_FORMAT_LINE_CHART_DATA,
                tableData: GET_TABLE_DATA,
                getGroupedParameter: GET_GROUPED_PARAMETER
            }),
            label() {
                const type = this.currentActiveButton;
                return this.buttons[type]['title'];
            }
        },
        created () {
            this.fetchPageData();
        },
        mounted() {
            this.$store.watch(
                (state) => state.selectedWebsite,
                (newValue, oldValue) => {
                    if(newValue !== oldValue) {
                        this.fetchPageData();
                    }
                }
            );
        },
        methods: {
            ...mapActions('page_timings', {
                changeGroupedParameter: CHANGE_GROUPED_PARAMETER,
                changeActiveButton: CHANGE_ACTIVE_BUTTON,
                changeSelectedPeriod: CHANGE_SELECTED_PERIOD,
                fetchPageData: FETCH_PAGE_DATA
            }),
            isButtonActive (type) {
                return this.currentActiveButton === type;
            },
            getButtonValue (type) {
                return this.buttonsData[type].value;
            },
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
</style>

