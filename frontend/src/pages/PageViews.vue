<template>
    <ContentLayout :title="title">
        <VLayout
            wrap
        />
        <VLayout>
            <VFlex
                lg12
                md12
                sm12
                xs12
                class="content-card"
            >
                <VLayout
                    wrap
                    align-center
                    justify-center
                >
                    <VFlex
                        class="chart-container"
                    >
                        <LineChart
                            :data="data"
                            :is-fetching="chartData.isFetching"
                        />
                        <PeriodDropdown
                            :value="getSelectedPeriod"
                            @change="changePeriod"
                        />
                    </VFlex>
                </VLayout>
            </VFlex>
        </VLayout>
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
                    :items="tableData"
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
    import {mapGetters, mapActions} from 'vuex';
    import {
        GET_BUTTON_DATA,
        GET_ACTIVE_BUTTON,
        GET_SELECTED_PERIOD,
        GET_LINE_CHART_DATA
    } from "@/store/modules/page_views/types/getters";
    import {
        CHANGE_ACTIVE_BUTTON,
        CHANGE_FETCHED_BUTTON_STATE,
        CHANGE_SELECTED_PERIOD
    } from "@/store/modules/page_views/types/actions";
    import {
        PAGE_VIEWS,
        UNIQUE_PAGE_VIEWS,
        ACTIVE_USERS,
        BOUNCE_RATE
    } from '../configs/page_views/buttonTypes.js';

    export default {
        components: {
            LineChart,
            GroupedTable,
            ButtonComponent,
            PeriodDropdown,
            ContentLayout
        },
        data() {
            return {
                data: [],
                period: '',
                items: [
                    {
                        page: 'www.figma.com/file/',
                        title: 'Login',
                        bounce_rate: '56',
                        exit_rate: '45',
                        page_views: '125',
                        avg_time: '00:00:30'
                    },
                    {
                        page: 'www.figma.com/file/',
                        title: 'Contacts',
                        bounce_rate: '56',
                        exit_rate: '45',
                        page_views: '125',
                        avg_time: '00:00:30'
                    },
                    {
                        page: 'www.figma.com/file/',
                        title: 'Home',
                        bounce_rate: '56',
                        exit_rate: '45',
                        page_views: '125',
                        avg_time: '00:00:30'
                    },
                    {
                        page: 'www.figma.com/file/',
                        title: 'Sign in',
                        bounce_rate: '56',
                        exit_rate: '45',
                        page_views: '125',
                        avg_time: '00:00:30'
                    },
                    {
                        page: 'www.figma.com/file/',
                        title: 'About',
                        bounce_rate: '56',
                        exit_rate: '45',
                        page_views: '125',
                        avg_time: '00:00:30'
                    }
                ],
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
                        title: 'Active users',
                        type: ACTIVE_USERS
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
            title () {
                return this.$route.meta.title;
            },
            tableData () {
                return this.items;
            },
            ...mapGetters('page_views', {
                buttonsData: GET_BUTTON_DATA,
                currentActiveButton: GET_ACTIVE_BUTTON,
                getSelectedPeriod: GET_SELECTED_PERIOD,
                chartData: GET_LINE_CHART_DATA,
            }),
            buttonData () {
                return this.buttonsData[this.type];
            }
        },
        mounted() {
            for (let i = 1; i < 20; i++) {
                const x = new Date(2019, 9, 5, i).toLocaleTimeString();
                const item = {
                    xLabel: x,
                    value: Math.floor(Math.random() * 2000) + 1,
                    indication: Math.floor(Math.random() * 200) + 1,
                };
                this.data.push(item);
            }
        },
        methods: {
            ...mapActions('page_views', {
                changeActiveButton: CHANGE_ACTIVE_BUTTON,
                changeSelectedPeriod: CHANGE_SELECTED_PERIOD
            }),
            changeButton (data) {
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
    .chart-container {
        box-shadow: 0px 0px 28px rgba(194, 205, 223, 0.7);
    }
</style>