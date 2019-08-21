<template>
    <VCol
        class="d-flex"
        cols="12"
        sm="6"
    >
        <VSelect
            :items="items"
            item-text="title"
            item-value="value"
            class="option-select"
            :value="getSelectedPeriod"
            solo
            return-object
            @change="change"
        />
    </VCol>
</template>

<script>
    import {CHANGE_SELECTED_PERIOD} from "@/store/modules/visitors/types/actions";
    import {mapGetters, mapActions} from 'vuex';
    import {GET_SELECTED_PERIOD} from "../../../store/modules/visitors/types/getters";

    export default {
        name: "PeriodDropdown",
        data() {
            return {
                items: [
                    {title: 'Today', value: 'today'},
                    {title: 'Yesterday', value: 'yesterday'},
                    {title: 'Last 7 days', value: 'last_week'},
                    {title: 'Last month', value: 'last_month'},
                    {title: 'Last quartal', value: 'last_quartal'},
                    {title: 'All period', value: 'all_period'}
                ]
            };
        },
        computed: {
            ...mapGetters('visitors', {
                getSelectedPeriod: GET_SELECTED_PERIOD
            })
        },
        methods: {
            ...mapActions('visitors', {
                changeSelectedPeriod: CHANGE_SELECTED_PERIOD
            }),
            change(selectedItem) {
                this.changeSelectedPeriod(selectedItem);
            }
        }
    };
</script>

<style lang="scss" scoped>
    $dark: #122737;
    $blue: #3C57DE;

    ::v-deep .option-select {
        padding: 0;
        max-width: 140px;
        max-height: 29px;
        background: #FFFFFF;
        box-sizing: border-box;
        border-radius: 6px;
        margin: 20px 24px 33px 28px;

        .v-select__selection {
            font-size: 12px;
            line-height: 14px;
            display: flex;
            align-items: center;
            letter-spacing: 0.533333px;
            color: #122737;
        }

        .v-icon {
            color: $blue;
        }

    }

    ::v-deep .v-list-item .v-list-item__title {
        font-size: 12px;
        line-height: 14px;
        display: flex;
        align-items: center;
        letter-spacing: 0.533333px;
        color: $dark;
    }
</style>