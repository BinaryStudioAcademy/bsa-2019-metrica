<template>
    <Spinner v-if="buttonData.isFetching" />
    <div
        v-else
        class="button-card bg-white d-inline-flex justify-content-start align-items-center"
        :class="{ active: isActive }"
        @click="changeButton"
    >
        <div
            class="card-image"
        >
            <img
                class="button-icon"
                :src="require(`@/assets/button_icons/${iconName}.png`)"
            >
        </div>
        <div
            class="card-text"
        >
            <div
                class="character-text text-no-wrap headline"
            >
                {{ buttonData.value }}
            </div>
            <div
                class="title-text text-no-wrap caption"
            >
                {{ title }}
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import Spinner from '../../utilites/Spinner';
    import {GET_BUTTON_DATA, GET_ACTIVE_BUTTON} from "@/store/modules/page_views/types/getters";
    import {CHANGE_ACTIVE_BUTTON, CHANGE_FETCHED_BUTTON_STATE} from "@/store/modules/page_views/types/actions";

    export default {
        name: 'ButtonComponent',
        components: {
            Spinner
        },
        props: {
            title: {
                type:String,
                required: true
            },
            type: {
                type:String,
                required: true
            },
            iconName: {
                type:String,
                required: true
            }
        },
        computed: {
            ...mapGetters('page_views', {
                buttonsData: GET_BUTTON_DATA,
                currentActiveButton: GET_ACTIVE_BUTTON
            }),
            isActive () {
                return this.currentActiveButton === this.type;
            },
            buttonData () {
                return this.buttonsData[this.type];
            }
        },
        methods: {
            ...mapActions('page_views', {
                changeActiveButton: CHANGE_ACTIVE_BUTTON,
                changeFetchingButtonState: CHANGE_FETCHED_BUTTON_STATE
            }),
            changeButton () {
                if (!this.isActive) {
                    this.changeActiveButton(this.type);
                }
            }
        }
    };
</script>

<style lang="scss" scoped>
    .button-card {
        font-family: Gilroy;
        height: 100px;
        min-width: 190px;
        border-radius: 6px;
        padding-right: 40px;
        padding-left: 20px;
        margin: 0 20px;
        transition: all .2s ease-in;

        .card-image {
            margin-right: 30px;

            .button-icon {
                height: 27px;
                width: 27px;
            }
        }

        .character-text {
            line-height: 29px;
            font-weight: 800;
        }

        .title-text {
            line-height: 14px;
            color: rgba(18, 39, 55, 0.5);
        }
    }
    .button-card:hover:not(.active) {
        cursor: pointer;
        border: 1px solid rgba(60, 87, 222, 0.52);
        transform: scale(1.1);
    }

    .button-card.active {
        box-shadow: 0px 0px 28px rgba(194, 205, 223, 0.7);
        border: 1px solid rgba(60, 87, 222, 0.52);
        transform: scale(1.19);
    }
</style>