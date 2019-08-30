<template>
    <ContentLayout :title="title">
        <Spinner
            v-if="isFetching"
        />
        <VRow>
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
        <VLayout class="buttons-row">
            <VFlex
                xs12
                sm8
                offset-sm2
            >
                <VLayout>
                    <VFlex
                        v-for="button in buttons"
                        :key="button.title"
                    >
                        <ButtonComponent
                            :title="button.title"
                            :active="isButtonActive(button.type)"
                            :fetching="buttonsData[button.type].isFetching"
                            :value="buttonsData[button.type].value"
                            :type="button.type"
                            :icon-name="button.icon"
                            @change="changeButton"
                        />
                    </VFlex>
                </VLayout>
            </VFlex>
        </VLayout>
        <VLayout>
            <VFlex
                lg12
                md12
                hidden-sm-and-down
                height="100%"
                class="img-card"
            >
                <GroupedTable
                    :items="getTableData"
                />
            </VFlex>
        </VLayout>
    </ContentLayout>
</template>

<script>
    import ContentLayout from '../components/layout/ContentLayout.vue';
    import LineChart from "../components/common/LineChart";
    import GroupedTable from "../components/dashboard/page_views/GroupedTable";
    import ButtonComponent from "../components/dashboard/common/ButtonComponent.vue";
    import PeriodDropdown from "../components/dashboard/common/PeriodDropdown.vue";
    import Spinner from "@/components/utilites/Spinner";
    import {mapGetters, mapActions} from 'vuex';
    import {
        GET_BUTTON_DATA,
        GET_ACTIVE_BUTTON,
        GET_SELECTED_PERIOD,
        GET_LINE_CHART_DATA,
        GET_FORMAT_LINE_CHART_DATA,
        GET_PAGE_VIEWS_TABLE_DATA,
        IS_FETCHING
    } from "@/store/modules/page_views/types/getters";
    import {
        CHANGE_ACTIVE_BUTTON,
        CHANGE_SELECTED_PERIOD,
        FETCH_PAGE_DATA,
        FETCH_PAGE_VIEWS_TABLE_DATA
    } from "@/store/modules/page_views/types/actions";
    import {
        PAGE_VIEWS,
        UNIQUE_PAGE_VIEWS,
        AVERAGE_TIME,
        BOUNCE_RATE
    } from '../configs/page_views/buttonTypes.js';

    export default {
        components: {
            LineChart,
            GroupedTable,
            ButtonComponent,
            PeriodDropdown,
            ContentLayout,
            Spinner
        },
        data() {
            return {
                data: [],
                period: '',
                buttons: [
                    {
                        icon: 'person',
                        title: 'Page views',
                        type: PAGE_VIEWS
                    },
                    {
                        icon: 'eye',
                        title: 'Unique page views',
                        type: UNIQUE_PAGE_VIEWS
                    },
                    {
                        icon: 'clock',
                        title: 'Avg. time on page',
                        type: AVERAGE_TIME
                    },
                    {
                        icon: 'yellow_arrow',
                        title: 'Bounce rate',
                        type: BOUNCE_RATE
                    }
                ],
            };
        },
        computed: {
            title() {
                return this.$route.meta.title;
            },
            ...mapGetters('page_views', {
                buttonsData: GET_BUTTON_DATA,
                currentActiveButton: GET_ACTIVE_BUTTON,
                getSelectedPeriod: GET_SELECTED_PERIOD,
                chartData: GET_LINE_CHART_DATA,
                formatLineChartData:GET_FORMAT_LINE_CHART_DATA,
                getTableData: GET_PAGE_VIEWS_TABLE_DATA,
                isFetching: IS_FETCHING
            }),
        },
        created() {
            this.fetchPageData();
            this.fetchTableData();
        },
        methods: {
            ...mapActions('page_views', {
                changeActiveButton: CHANGE_ACTIVE_BUTTON,
                changeSelectedPeriod: CHANGE_SELECTED_PERIOD,
                fetchPageData: FETCH_PAGE_DATA,
                fetchTableData: FETCH_PAGE_VIEWS_TABLE_DATA,
            }),
            changeButton(data) {
                this.changeActiveButton(data);
            },
            changePeriod(data) {
                this.changeSelectedPeriod(data);
            },
            isButtonActive(type) {
                return this.currentActiveButton === type;
            }
        }
    };
</script>

<style scoped>
.buttons-row {
    margin-top: 50px;
}
.card {
    border-radius: 6px;
    box-shadow: 0px 0px 28px rgba(194, 205, 223, 0.7);
}
</style>