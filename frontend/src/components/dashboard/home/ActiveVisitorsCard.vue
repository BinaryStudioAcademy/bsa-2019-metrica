<template>
    <div class="mt-10">
        <div class="subtitle-1 pl-1 pb-4 grey--text text--darken-1">
            Activity
        </div>
        <div class="card pa-6 bg-white visitors-card text-dark position-relative justify-content-between">
            <Spinner v-if="activityDataFetching" />
            <div class="d-flex justify-content-between align-items-center card-top-row ">
                <p class="card-text mb-0">
                    Active visitors
                </p>
                <p class="card-count text-right mb-0">
                    <strong>
                        {{ activeUsersCount }}
                    </strong>
                </p>
            </div>
            <div class="d-flex justify-content-between align-items-center card-top-row">
                <p class="card-text mb-0">
                    Pages currently viewing
                </p>
                <p class="card-count text-right mb-0">
                    <strong>
                        {{ pageViewsCount }}
                    </strong>
                </p>
            </div>
            <VContainer>
                <VueApexCharts
                    type="bar"
                    height="200px"
                    width="100%"
                    :options="options"
                    :series="series"
                    class="visits-heatmap"
                />
            </VContainer>
            <TopActivePage
                :top-pages="topPages"
            />
            <div
                class="text-center"
            >
                <RouterLink
                    :to="{ name: 'page-views'}"
                    class="btn card-button font-weight-light rounded"
                    @click.native="setPeriod"
                >
                    Page views overview
                </RouterLink>
            </div>
        </div>
    </div>
</template>

<script>
    import Spinner from '../../utilites/Spinner';
    import moment from 'moment';
    import VueApexCharts from 'vue-apexcharts';
    import {mapGetters, mapActions} from 'vuex';
    import {
        GET_ACTIVITY_DATA_ITEMS,
        GET_ACTIVITY_DATA_FETCHING,
        GET_ACTIVITY_CHART_DATA,
    } from "@/store/modules/dashboard/types/getters";
    import _ from "lodash";
    import {echoInstance} from '../../../services/echoService';
    import {GET_CURRENT_WEBSITE} from '@/store/modules/website/types/getters';
    import {
        FETCHING_ACTIVITY_DATA_ITEMS,
        RELOAD_ACTIVITY_DATA_ITEMS,
        REFRESH_ACTIVITY_DATA_ITEMS
    } from "@/store/modules/dashboard/types/actions";
    import TopActivePage from "@/components/dashboard/home/TopActivePage";
    import {FETCHING_ACTIVITY_CHART_DATA} from "../../../store/modules/dashboard/types/actions";
    export default {
        name: 'ActiveVisitorsCard',
        components: {
            TopActivePage,
            Spinner,
            VueApexCharts
        },
        data: () => ({
            lineWidth: 4,
            radius: 16,
            padding: 4,
            gradient: ['#3C57DE', '#1BC3DA'],
            gradientDirection: 'left',
            polling: null,
            fetch: null,
            options: {
                chart: {
                    id: 'vuechart',
                    toolbar: {
                        show: false
                    },
                    fontFamily: 'Gilroy'
                },
            }
        }),
        mounted() {
            const channel = echoInstance.private('active-users.'+ this.website.id);
            channel.listen('ActiveUserEvent', (data) => {
                this.refreshActivityDataItems(data);
                this.fetchingActiveUsersChartData();
            });
        },
        computed: {
            ...mapGetters('dashboard', {
                activityDataItems: GET_ACTIVITY_DATA_ITEMS,
                activityDataFetching: GET_ACTIVITY_DATA_FETCHING,
                activityChartData: GET_ACTIVITY_CHART_DATA,
            }),
            ...mapGetters('website', {
                website: GET_CURRENT_WEBSITE
            }),
            activeUsersCount() {
                return _.uniqBy(this.activityDataItems, 'visitor').length;
            },
            pageViewsCount() {
                return _.uniqBy(this.activityDataItems, 'url').length;
            },
            topPages() {
                const result = _(this.activityDataItems)
                    .groupBy('url')
                    .map((items, url) => {

                        return { url: url, count: items.length };
                    }).value();

                const sort = _.sortBy(result, ['count']).reverse();
                if(sort.length > 3) {
                    return sort.slice(0, 3);
                }
                return sort;
            },
            series() {
                let data = [];
                let i = this.activityChartData.length - 1;
                this.activityChartData.forEach((item) => {
                    data.push({
                        x: moment().subtract(i, 'minute').format('HH:mm'),
                        y: item
                    });
                    i--;
                });
                return  [{
                    name: 'count pages',
                    data: data
                }];
            },

        },
        created() {
            this.fetchingActiveUsersNumbers();
            this.fetchingActiveUsersChartData();
            this.setIntervalDataActivity();
        },
        beforeDestroy () {
            clearInterval(this.polling);
            clearInterval(this.fetch);
        },
        methods: {
            ...mapActions('dashboard', {
                fetchingActiveUsersNumbers: FETCHING_ACTIVITY_DATA_ITEMS,
                reloadActivityDataItems: RELOAD_ACTIVITY_DATA_ITEMS,
                fetchingActiveUsersChartData: FETCHING_ACTIVITY_CHART_DATA,
                refreshActivityDataItems: REFRESH_ACTIVITY_DATA_ITEMS,
            }),
            setIntervalDataActivity () {
                this.polling = setInterval(() => {
                    this.reloadActivityDataItems();
                    this.fetchingActiveUsersChartData();
                }, 300000);
            },
            setPeriod() {
                this.$store.state.page_views.selectedPeriod = 'today';
            },
        }
    };
</script>

<style lang="scss" scoped>
    .visits-heatmap {
        margin: 0 -22px 0 -32px;
    }
    .visitors-card {
        border: none;
        box-shadow: 0px 0px 28px rgba(194, 205, 223, 0.7);
        border-radius: 6px;
        font-family: Gilroy;
        width: 352px;
        font-size: 12px;
        height: 580px;

        .card-top-row {
            height: 53px;

            .card-text {
                color: rgba(18, 39, 55, 0.5);
            }

            .card-count {
                font-size: 24px;
            }
        }
        .card-button {
            height: 32px;
            background: #3C57DE;
            color:#ffffff;
            font-size: 12px;
        }
    }
</style>
