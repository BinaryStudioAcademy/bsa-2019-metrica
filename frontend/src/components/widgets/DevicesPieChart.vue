<template>
    <div class="mt-10">
        <div class="subtitle-1 pl-1 pb-4 grey--text text--darken-1">
            Devices
        </div>
        <div class="pa-6 white pie-container position-relative d-flex flex-column justify-space-between">
            <Spinner v-if="isFetching" />
            <VContainer
                v-if="noData"
                fill-height
                class="d-flex align-center justify-content-center grey--text"
            >
                There is no data to display.
            </VContainer>
            <PieChartItem
                v-else
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
    import { isChangeSelectedWebsite } from "@/mixins/isChangeSelectedWebsite";
    import Spinner from '@/components/utilites/Spinner';
    import PeriodDropdown from "@/components/dashboard/common/PeriodDropdown";
    import PieChartItem from "@/components/widgets/PieChartItem";
    import { mapGetters, mapActions } from "vuex";
    import { echoInstance } from "../../services/echoService";
    import {
        GET_SELECTED_PERIOD,
        GET_WIDGET_DATA,
        GET_FETCHING_STATUS
    } from "@/store/modules/devices/types/getters";
    import {
        CHANGE_SELECTED_PERIOD,
        FETCH_WIDGET_INFO
    } from "@/store/modules/devices/types/actions";
    import {GET_CURRENT_WEBSITE} from "../../store/modules/website/types/getters";

    export default {
        components: {
            Spinner,
            PeriodDropdown,
            PieChartItem
        },
        mixins: [isChangeSelectedWebsite],
        created() {
            this.fetchWidgetInfo();
        },
        mounted() {
            const channel = echoInstance.private('stats.'+ this.website.id);
            channel.listen('StatsChangeEvent', () => {
                this.fetchWidgetInfo(false);
            });
        },
        computed: {
            ...mapGetters('devices', {
                selectedPeriod: GET_SELECTED_PERIOD,
                data: GET_WIDGET_DATA,
                isFetching: GET_FETCHING_STATUS
            }),
            ...mapGetters('website', {
                website: GET_CURRENT_WEBSITE
            }),
            noData() {
                return this.data.some(function(element) {
                    return element.data.length === 0;
                });
            }
        },
        methods: {
            ...mapActions('devices', {
                changeSelectedPeriod: CHANGE_SELECTED_PERIOD,
                fetchWidgetInfo: FETCH_WIDGET_INFO
            }),
            onWebsiteChange () {
                this.fetchWidgetInfo();
            }
        }
    };
</script>

<style scoped lang="scss">
.pie-container {
    box-shadow: 0 0 28px rgba(0, 0, 0, 0.11) !important;
    border-radius: 6px;
    width: 352px;
    height: 580px;
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
