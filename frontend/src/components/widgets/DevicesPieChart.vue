<template>
    <VContainer class="white pie-container position-relative mx-0">
        <Spinner v-if="isFetching" />
        <VContainer class="content pt-1 d-flex flex-column justify-space-between">
            <VContainer v-if="!data.length">
                no data to display
            </VContainer>
            <PieChartItem
                v-for="(item, key) in data"
                :data-type="item.type"
                :data="item.data"
                :key="key"
            />
            <PeriodDropdown
                class="mt-2"
                :value="selectedPeriod"
                @change="changeSelectedPeriod"
            />
        </VContainer>
    </VContainer>
</template>

<script>
    import Spinner from '@/components/utilites/Spinner';
    import PeriodDropdown from "@/components/dashboard/common/PeriodDropdown";
    import PieChartItem from "@/components/widgets/PieChartItem";
    import { mapGetters, mapActions } from "vuex";
    import {
        GET_SELECTED_PERIOD,
        GET_WIDGET_DATA,
        GET_FETCHING_STATUS
    } from "@/store/modules/devices/types/getters";
    import { CHANGE_SELECTED_PERIOD } from "@/store/modules/devices/types/actions";

    export default {
        components: {
            Spinner,
            PeriodDropdown,
            PieChartItem
        },
        computed: {
            ...mapGetters('devices', {
                selectedPeriod: GET_SELECTED_PERIOD,
                data: GET_WIDGET_DATA,
                isFetching: GET_FETCHING_STATUS
            })
        },
        methods: {
            ...mapActions('devices', {
                changeSelectedPeriod: CHANGE_SELECTED_PERIOD
            })
        }
    };
</script>

<style scoped lang="scss">
.pie-container {
    box-shadow: 0 0 28px rgba(0, 0, 0, 0.11) !important;
    border-radius: 6px;
    width: 307px;
    height: 100%;
}
.header {
    font-size: 16px;
    line-height: 19px;
    width: max-content;
}
.content {
    height: 100%;
}
</style>
