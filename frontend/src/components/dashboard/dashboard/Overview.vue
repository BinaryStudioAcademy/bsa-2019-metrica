<template>
    <VContainer
        class="overview px-7 py-6 position-relative"
    >
        <WidgetButtons
            name="Visitors"
        />
        <LineChart
            :data="chartData.items"
            :is-fetching="chartData.isFetching"
        />
        <PeriodDropdown
            :value="selectedPeriod"
            @change="refreshData"
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
        FETCH_LINE_CHART_DATA
    } from "@/store/modules/dashboard/types/actions";
    export default {
        computed: {
            title () {
                return this.$route.meta.title;
            },
            ...mapGetters('dashboard', {
                chartData: GET_LINE_CHART_DATA,
                selectedPeriod: GET_SELECTED_PERIOD,
            }),
        },
        methods: {
            ...mapActions('dashboard', {
                changeSelectedPeriod: CHANGE_SELECTED_PERIOD,
                getLineChartData: FETCH_LINE_CHART_DATA
            }),
            refreshData(data) {
                this.changeSelectedPeriod(data);
                this.getLineChartData();
            }
        },
        name: "Overview",
        components: { WidgetButtons, LineChart, PeriodDropdown }
    };
</script>

<style scoped lang="scss">
    .overview {
        background-color: white;
        box-shadow: 0px 0px 28px rgba(194, 205, 223, 0.7);
        border-radius: 6px;
    }
</style>