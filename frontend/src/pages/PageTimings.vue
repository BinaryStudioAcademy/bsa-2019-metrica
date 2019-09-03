<template>
    <ContentLayout :title="title">
        <VRow>
            <VContainer class="white card px-7 py-6">
                <LineChart
                    :data="chartData.items"
                    :is-fetching="chartData.isFetching"
                />
                <PeriodDropdown
                    :value="getSelectedPeriod"
                    @change="changePeriod"
                />
            </VContainer>
        </VRow>
        <VRow
            class="buttons-row justify-sm-center justify-lg-start justify-xl-space-between "
        >
            <ButtonComponent
                v-for="button in buttons"
                :key="button.title"
                :title="button.title"
                :active="isButtonActive(button.type)"
                :fetching="buttonsData[button.type].isFetching"
                :value="getButtonValue(button.type)"
                :type="button.type"
                :icon-name="button.icon"
                @change="changeButton"
            />
        </VRow>
    </ContentLayout>
</template>

<script>
    import ContentLayout from '../components/layout/ContentLayout.vue';
    import LineChart from "../components/common/LineChart";
    import ButtonComponent from "../components/dashboard/common/ButtonComponent.vue";
    import PeriodDropdown from "../components/dashboard/common/PeriodDropdown.vue";
    import {mapGetters, mapActions} from 'vuex';
    import {
        GET_BUTTON_DATA,
        GET_ACTIVE_BUTTON,
        GET_SELECTED_PERIOD,
        GET_LINE_CHART_DATA,
    } from "@/store/modules/page_timings/types/getters";
    import {
        CHANGE_ACTIVE_BUTTON,
        CHANGE_SELECTED_PERIOD,
        FETCH_PAGE_DATA
    } from "@/store/modules/page_timings/types/actions";
    import {
        AVG_PAGE_LOAD_TIME,
        AVG_LOOKUP_TIME,
        AVG_SERVER_RESPONSE_TIME,
    } from '../configs/page_timings/buttonTypes.js';

    export default {
        components: {
            LineChart,
            ButtonComponent,
            PeriodDropdown,
            ContentLayout
        },
        data() {
            return {
                title: "Page Timings",
                buttons: [
                    {
                        icon: 'yellow_arrow',
                        title: 'Avg. Page Load Time',
                        type: AVG_PAGE_LOAD_TIME
                    },
                    {
                        icon: 'eye',
                        title: 'Avg. Domain Lookup Time',
                        type: AVG_LOOKUP_TIME
                    },
                    {
                        icon: 'clock',
                        title: 'Avg. Server Response Time',
                        type: AVG_SERVER_RESPONSE_TIME
                    },
                ],
            };
        },
        computed: {
            ...mapGetters('page_timings', {
                buttonsData: GET_BUTTON_DATA,
                currentActiveButton: GET_ACTIVE_BUTTON,
                getSelectedPeriod: GET_SELECTED_PERIOD,
                chartData: GET_LINE_CHART_DATA,
            }),
        },
        created () {
            this.fetchPageData();
        },
        methods: {
            ...mapActions('page_timings', {
                changeActiveButton: CHANGE_ACTIVE_BUTTON,
                changeSelectedPeriod: CHANGE_SELECTED_PERIOD,
                fetchPageData: FETCH_PAGE_DATA
            }),
            changeButton (data) {
                this.changeActiveButton(data);
            },
            changePeriod (data) {
                this.changeSelectedPeriod(data);
            },
            isButtonActive (type) {
                return this.currentActiveButton === type;
            },
            getButtonValue (type) {
                return this.buttonsData[type].value;
            }
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
