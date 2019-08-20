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
            class="period-dropdown"
            v-model="selectedItem"
            solo
            return-object
            @change="change"
        />
    </VCol>
</template>

<script>
    import {CHANGE_SELECTED_PERIOD} from "../../../store/modules/visitors/types/actions";
    import {mapActions} from 'vuex';

    export default {
        name: "PeriodDropdown",
        data() {
            return {
                selectedItem: {
                    value: 'last_week'
                },
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
        methods: {
            ...mapActions('visitors', {
                changeSelectedPeriod: CHANGE_SELECTED_PERIOD
            }),
            change() {
                this.changeSelectedPeriod(this.selectedItem);
            }
        }
    };
</script>

<style lang="scss" scoped>
    .period-dropdown {
        max-width: 140px;
        max-height: 29px;
        background: #FFFFFF;
        border: 1px solid rgba(18, 39, 55, 0.116);
        box-sizing: border-box;
        border-radius: 6px;

        ::v-deep .v-select__selection {
            font-size: 12px;
            line-height: 14px;
            display: flex;
            align-items: center;
            letter-spacing: 0.533333px;
            color: #122737;
        }

    }
    ::v-deep .v-list-item .v-list-item__title{
        font-size: 12px;
        line-height: 14px;
        display: flex;
        align-items: center;
        letter-spacing: 0.533333px;
        color: #122737;
    }


</style>