<template>
    <VContainer
        class="overview px-7 py-6 position-relative d-flex flex-column justify-space-between"
    >
        <WidgetButtons
            name="Visitors"
        />
        <LineChart
            :data="chartData"
            :is-fetching="isFetching"
            :units="units"
        />
        <PeriodDropdown
            :value="selectedPeriod"
            @change="changeSelectedPeriod"
        />
    </VContainer>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';
    import PeriodDropdown from "../common/PeriodDropdown";
    import LineChart from "../../common/LineChart";
    import WidgetButtons from "./WidgetButtons";
    import {BOUNCE_RATE} from "../../../configs/visitors/buttonTypes";
    import {
        GET_FORMAT_LINE_CHART_DATA,
        GET_SELECTED_PERIOD,
        GET_LINE_CHART_FETCHING,
        GET_DATA_TYPE
    } from "@/store/modules/dashboard/types/getters";
    import {
        CHANGE_SELECTED_PERIOD,
        FETCH_LINE_CHART_DATA
    } from "@/store/modules/dashboard/types/actions";
    export default {
        name: "Overview",
        components: { WidgetButtons, LineChart, PeriodDropdown },
        created() {
            this.fetchChartData();
        },
        computed: {
            ...mapGetters('dashboard', {
                chartData: GET_FORMAT_LINE_CHART_DATA,
                isFetching: GET_LINE_CHART_FETCHING,
                selectedPeriod: GET_SELECTED_PERIOD,
                dataType: GET_DATA_TYPE
            }),
            units() {
                return this.dataType === BOUNCE_RATE ? '%' : '';
            },
        },
        methods: {
            ...mapActions('dashboard', {
                changeSelectedPeriod: CHANGE_SELECTED_PERIOD,
                fetchChartData: FETCH_LINE_CHART_DATA
            }),
        }
    };
</script>

<style scoped lang="scss">
    .overview {
        height: 100%;
        width: 100%;
        margin: 0;
        min-width: 800px;
        background-color: white;
        box-shadow: 0px 0px 28px rgba(194, 205, 223, 0.7);
        border-radius: 6px;
    }
    .chart {
        margin: 0;
    }
</style>
