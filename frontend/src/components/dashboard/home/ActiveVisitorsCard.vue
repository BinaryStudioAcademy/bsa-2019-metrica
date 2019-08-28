<template>
    <div class="card bg-white visitors-card rounded shadow text-dark">
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
    import {mapGetters, mapActions} from 'vuex';
    import _ from "lodash";
    import {echoInstance} from '../../../services/echoService';
    import {GET_ACTIVITY_DATA_ITEMS} from "@/store/modules/dashboard/types/getters";
    import {GET_AUTHENTICATED_USER} from '@/store/modules/auth/types/getters';
    import {FETCHING_ACTIVITY_DATA_ITEMS, RELOAD_ACTIVITY_DATA_ITEMS} from "@/store/modules/dashboard/types/actions";
    import TopActivePage from "@/components/dashboard/home/TopActivePage";
    export default {
        name: 'ActiveVisitorsCard',
        components: {
            TopActivePage
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
            echoInstance.private('App.Entities.User.' + 52).notification((notification) => {
                console.log(notification);
            });
            console.log(echoInstance);
        },
        computed: {
            ...mapGetters('dashboard', {
                activityDataItems: GET_ACTIVITY_DATA_ITEMS,
            }),
            ...mapGetters('auth', {
                user: GET_AUTHENTICATED_USER
            }),
            activeUsersCount() {
                return _.uniqBy(this.activityDataItems, 'visitorId').length;
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
                if(result.length > 3) {
                    return result.slice(0, 2);
                }
                return result;
            }
        },
        created() {
            this.fetchingActivityDataItems();
            this.filterDataActivity();
            console.log(this.user);
        },
        beforeDestroy () {
            clearInterval(this.polling);
        },
        methods: {
            ...mapActions('dashboard', {
                fetchingActivityDataItems: FETCHING_ACTIVITY_DATA_ITEMS,
                reloadActivityDataItems: RELOAD_ACTIVITY_DATA_ITEMS,
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
        font-family: Gilroy;
        width: 307px;
        font-size: 12px;
        padding: 43px 33px 32px 28px;

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
