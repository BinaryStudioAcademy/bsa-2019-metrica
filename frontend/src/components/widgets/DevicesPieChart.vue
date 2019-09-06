<template>
    <div>
        <div class="subtitle-1 pl-1 pb-4 grey--text text--darken-1">
            Devices
        </div>
        <div class="pa-6 white pie-container position-relative d-flex flex-column justify-space-between">
            <Spinner v-if="isFetching" />
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
                :value="selectedPeriod"
                @change="changeSelectedPeriod"
            />
        </div>
    </div>
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
    import {
        CHANGE_SELECTED_PERIOD,
        FETCH_WIDGET_INFO
    } from "@/store/modules/devices/types/actions";

    export default {
        components: {
            Spinner,
            PeriodDropdown,
            PieChartItem
        },
        created() {
            this.fetchWidgetInfo();
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
                changeSelectedPeriod: CHANGE_SELECTED_PERIOD,
                fetchWidgetInfo: FETCH_WIDGET_INFO
            })
        }
    };
</script>

<style scoped lang="scss">
.pie-container {
    box-shadow: 0 0 28px rgba(0, 0, 0, 0.11) !important;
    border-radius: 6px;
    width: 352px;
    min-height: 480px;
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
