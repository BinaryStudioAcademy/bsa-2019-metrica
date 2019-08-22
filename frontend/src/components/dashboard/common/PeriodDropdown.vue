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
            :value="value"
            solo
            return-object
            @change="changePeriod"
        />
    </VCol>
</template>

<script>
    export default {
        name: "PeriodDropdown",
        props: {
            value: {
                type:String,
                required: true
            },
        },
        data() {
            return {
                items: [
                    {title: 'Today', value: 'today'},
                    {title: 'Yesterday', value: 'yesterday'},
                    {title: 'Last 7 days', value: 'last_week'},
                    {title: 'Last 30', value: 'last_month'},
                    {title: 'Last 90', value: 'last_quartal'},
                    {title: 'All period', value: 'all_period'}
                ]
            };
        },
        methods: {
            changePeriod(selectedItem) {
                this.$emit("change", selectedItem);
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