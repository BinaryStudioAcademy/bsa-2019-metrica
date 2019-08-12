<template>
    <div class="card bg-white visitors-card">
        <div class="d-flex justify-content-between align-items-center card-top-row">
            <p class="card-text mb-0">
                Active users
            </p>
            <p class="card-count text-right mb-0">
                {{ activeUsersCount }}
            </p>
        </div>
        <div class="d-flex justify-content-between align-items-center card-top-row">
            <p class="card-text mb-0">
                Page views now
            </p>
            <p class="card-count text-right mb-0">
                {{ pageViewsCount }}
            </p>
        </div>
        <p
            class="card-title"
        >
            Top active pages
        </p>
        <ul
            class="links-list m-0 p-0"
        >
            <li
                v-for="page in topPages"
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
                class="btn card-button font-weight-light"
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
                default: function () {
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
        padding: 43px 33px 32px 28px;
        background: #FFFFFF;
        box-shadow: 0px 0px 28px rgba(0, 0, 0, 0.11);
        border-radius: 6px;
        font-size: 12px;
        color: #000000;

        .card-top-row {
            height: 53px;

            .card-text {
                color: rgba(18, 39, 55, 0.5);
            }

            .card-count {
                font-size: 24px;
                font-weight: 900;
            }
        }
        .card-title {
            margin-top: 18px;
            margin-bottom: 31px;
        }

        .links-list {
            list-style: none;

            li {
                padding: 5px 0;
                margin-bottom: 10px;

                .link-item {
                    text-decoration:none;
                    color: rgba(18, 39, 55, 0.5);
                }
            }
        }

        .card-button {
            height: 32px;
            width: 126px;
            background: #3C57DE;
            border-radius: 3px;
            color:#ffffff;
            font-size: 12px;
        }

    }
</style>