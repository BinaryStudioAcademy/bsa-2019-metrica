<template>
    <div class="card bg-white visitors-card rounded text-dark position-relative justify-content-between">
        <Spinner v-if="isFetching" />
        <div class="d-flex justify-content-between align-items-center card-top-row">
            <p class="card-text mb-0">
                Active users
            </p>
            <p class="card-count text-right mb-0">
                <strong>
                    {{ activeUsersCount }}
                </strong>
            </p>
        </div>
        <div class="d-flex justify-content-between align-items-center card-top-row">
            <p class="card-text mb-0">
                Page views now
            </p>
            <p class="card-count text-right mb-0">
                <strong>
                    {{ pageViewsCount }}
                </strong>
            </p>
        </div>
        <VContainer>
            <VSparkline
                v-if="activityChartData.length > 0"
                :value="activityChartData"
                :gradient="gradient"
                :smooth="radius"
                :padding="padding"
                :line-width="lineWidth"
                :gradient-direction="gradientDirection"
                auto-draw
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
            >
                Real time report
            </RouterLink>
        </div>
    </div>
</template>

<script>
    import Spinner from '../../utilites/Spinner';
    import {mapGetters, mapActions} from 'vuex';
    import _ from "lodash";
    import {echoInstance} from '../../../services/echoService';
    import {GET_ACTIVITY_DATA_ITEMS} from "@/store/modules/dashboard/types/getters";
    import {GET_CURRENT_WEBSITE} from '@/store/modules/website/types/getters';
    import {
        FETCHING_ACTIVITY_DATA_ITEMS,
        RELOAD_ACTIVITY_DATA_ITEMS,
        REFRESH_ACTIVITY_DATA_ITEMS
    } from "@/store/modules/dashboard/types/actions";
    import TopActivePage from "@/components/dashboard/home/TopActivePage";
    export default {
        name: 'ActiveVisitorsCard',
        components: {
            TopActivePage,
            Spinner,
        },
        props: {
            activityChartData: {
                type: Array,
                required: true,
            },
            isFetching: {
                type: Boolean,
                required: true,
            },
        },
        data: () => ({
            lineWidth: 5,
            radius: 16,
            padding: 4,
            gradient: ['#3C57DE', '#1BC3DA'],
            gradientDirection: 'left',
            polling: null,
        }),
        mounted() {
            const channel = echoInstance.private('active-users.'+ this.website.id);
            channel.listen('ActiveUserEvent', (data) => this.refreshActivityDataItems(data));
        },
        computed: {
            ...mapGetters('dashboard', {
                activityDataItems: GET_ACTIVITY_DATA_ITEMS,
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
            }
        },
        created() {
            this.fetchingActivityDataItems();
            this.filterDataActivity();
        },
        beforeDestroy () {
            clearInterval(this.polling);
        },
        methods: {
            ...mapActions('dashboard', {
                fetchingActivityDataItems: FETCHING_ACTIVITY_DATA_ITEMS,
                reloadActivityDataItems: RELOAD_ACTIVITY_DATA_ITEMS,
                refreshActivityDataItems: REFRESH_ACTIVITY_DATA_ITEMS,
            }),
            filterDataActivity () {
                this.polling = setInterval(() => {
                    this.reloadActivityDataItems();
                }, 300000);
            }
        }
    };
</script>

<style lang="scss" scoped>
    .visitors-card {
        border: none;
        box-shadow: 0px 0px 28px rgba(194, 205, 223, 0.7);
        font-family: Gilroy;
        width: 307px;
        font-size: 12px;
        padding: 43px 33px 32px 28px;
        height: 100%;

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
            width: 126px;
            background: #3C57DE;
            color:#ffffff;
            font-size: 12px;
        }

    }
</style>
