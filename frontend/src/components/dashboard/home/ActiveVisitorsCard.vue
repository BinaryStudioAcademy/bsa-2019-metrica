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
                v-if="chartData.length > 0"
                :value="chartData"
                :gradient="gradient"
                :smooth="radius"
                :padding="padding"
                :line-width="lineWidth"
                :gradient-direction="gradientDirection"
                auto-draw
            />
        </VContainer>
        <ul
            class="links-list m-0 p-0"
        >
            <li class="card-title">
                <p>Top active pages</p>
                <p>Users</p>
            </li>
            <li
                v-for="page in topPages"
                class="mb-2 mt-1 px-0 py-1"
                :key="page.url"
            >
                <a
                    class="link-item"
                    :href="page.url"
                >
                    {{ page.url }}
                </a>
                <p>{{ page.count }}</p>
            </li>
        </ul>
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
    export default {
        name: 'ActiveVisitorsCard',
        props: {
            data: {
                type: Array,
                required: true,
            },
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
        }),
        computed: {
            chartData() {
                return this.activityChartData;
            },
            activeUsersCount() {
                return this.data.map(item => item.visitorId)
                    .filter((value, index, self) => self.indexOf(value) === index).length;
            },
            pageViewsCount() {
                return this.data.map(item => item.url)
                    .filter((value, index, self) => self.indexOf(value) === index).length;
            },
            topPages() {
                let mapGroups = this.data.reduce((obj, item) => {
                    obj.group[item.url] = obj.group[item.url] || {
                        url: item.url,
                        count: 0
                    };
                    obj.group[item.url].count += 1;
                    return obj;
                }, {group: {}});

                mapGroups = Object.values(mapGroups.group);
                let mapGroupsSort = mapGroups.sort(function (a, b) {
                    return  b.visitors - a.visitors;
                });
                if(mapGroupsSort.length > 3) {
                    return mapGroupsSort.slice(0, 2);
                }
                return mapGroupsSort;
            }
        },
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

        .links-list {
            list-style: none;
            li {
                display: flex;
                justify-content: space-between;
            }
            .link-item {
                text-decoration:none;
                color: rgba(18, 39, 55, 0.5);
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
