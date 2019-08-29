<template>
    <VContainer
        class="overview px-7 py-6 position-relative d-flex flex-column justify-space-between"
    >
        <WidgetButtons
            name="Visitors"
        />
        <LineChart
            class="chart"
            :data="chartData.items"
            :interval="selectedPeriod"
            :is-fetching="chartData.isFetching"
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
    import {
        GET_LINE_CHART_DATA,
        GET_SELECTED_PERIOD
    } from "@/store/modules/dashboard/types/getters";
    import {
        CHANGE_SELECTED_PERIOD,
    } from "@/store/modules/dashboard/types/actions";
    export default {
        name: "Overview",
        components: { WidgetButtons, LineChart, PeriodDropdown },
        computed: {
            ...mapGetters('dashboard', {
                chartData: GET_LINE_CHART_DATA,
                selectedPeriod: GET_SELECTED_PERIOD,
            }),
        },
        methods: {
            ...mapActions('dashboard', {
                changeSelectedPeriod: CHANGE_SELECTED_PERIOD,
            }),
        }
    };
</script>

<style scoped lang="scss">
    .overview {
        height: 394px;
        width: 100%;
        margin: 0;
        min-width: 800px;
        background-color: white;
        box-shadow: 0px 0px 28px rgba(194, 205, 223, 0.7);
        border-radius: 6px;
    }
    .chart {
        /*width: 90%;*/
        margin: 0;
    }
</style>