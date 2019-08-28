<template>
    <VContainer class="wrapper pa-0">
        <VSubheader
            class="header mb-4 pl-0 text-dark"
        >
            Devices
        </VSubheader>
        <VContainer class="white pie-container position-relative">
            <Spinner v-if="isFetching" />
            <VContainer class="pt-1">
                <PieChartItem
                    v-for="(item, key) in data"
                    :data-type="item.type"
                    :data="item.data"
                    :key="key"
                />
                <VRow class="pl-3">
                    <PeriodDropdown
                        :value="selectedPeriod"
                        @change="changeSelectedPeriod"
                    />
                </VRow>
            </VContainer>
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
.wrapper {
    width: max-content !important;
    margin: 0;
}
.pie-container {
    box-shadow: 0 0 28px rgba(0, 0, 0, 0.11) !important;
    border-radius: 6px;
    width: 307px;
    height: 394px;
}
.header {
    font-size: 16px;
    line-height: 19px;
    width: max-content;
}
</style>
