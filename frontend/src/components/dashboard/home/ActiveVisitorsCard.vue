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
        <p
            class="card-title mt-3 mb-5"
        >
            Top active pages
        </p>
        <ul
            class="links-list m-0 p-0"
        >
            <li
                v-for="page in topPages"
                class="mb-2 mt-1 px-0 py-1"
                :key="page"
            >
                <a
                    class="link-item"
                    href="#"
                >
                    {{ page }}
                </a>
            </li>
        </ul>
        <div
            class="text-center"
        >
            <a
                href="#"
                class="btn card-button font-weight-light rounded"
            >
                Real time
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'ActiveVisitorsCard',
        props: {
            activeUsersCount: {
                type: Number,
                default: 250
            },
            pageViewsCount: {
                type: Number,
                default: 31
            },
            topPages: {
                type: Array,
                default: () =>  {
                    return ['link_1/juhy/kkk', 'link_2/juhy/klk', 'link_3/juk/jjj'];
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .visitors-card {
        font-family: Gilroy;
        height: 382px;
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