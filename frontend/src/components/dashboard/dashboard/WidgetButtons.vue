<template>
    <VItemGroup
        @change="changeDataTypeToFetch"
        mandatory
        :value="dataToFetch"
    >
        <VItem
            v-for="button in buttons"
            :key="button.label"
            v-slot:default="{ active, toggle }"
            :value="button.value"
        >
            <VBtn
                :ripple="false"
                text
                rounded
                :key="button.label"
                :class="active ? 'cyan white--text active' : 'inactive'"
                @click="toggle"
            >
                {{ button.label }}
            </VBtn>
        </VItem>
    </VItemGroup>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    import { GET_DATA_TYPE } from "../../../store/modules/dashboard/types/getters";
    import { CHANGE_DATA_TYPE } from "../../../store/modules/dashboard/types/actions";

    export default {
        name: "WidgetButtons",
        data() {
            return {
                buttons: [
                    { label: 'Visitors', value: 'total_visitors' },
                    { label: 'Pages', value: 'page_views' },
                    { label: 'Bounce Rate', value: 'bounce_rate' },
                ]
            };
        },
        computed: {
            ...mapGetters('dashboard', {
                dataToFetch: GET_DATA_TYPE
            })
        },
        methods: {
            ...mapActions('dashboard', {
                changeDataType: CHANGE_DATA_TYPE
            }),
            changeDataTypeToFetch(value) {
                this.changeDataType(value);
            }
        },
    };
</script>

<style scoped lang="scss">
    .v-item-group {
        .v-btn {
            border-radius: 18px;
            font-size: 12px;
            line-height: 14px;
            text-transform: none;
            padding: 3px 15px;
            height: 100%;
            font-family: 'GilroySemiBold';
            &:not(:last-child) {
                margin-right: 16px;
            }
            &.active {
                border: 1px solid #1BC3DA !important;
            }

            &.inactive {
                border: 1px solid rgba(18, 39, 55, 0.116) !important;
            }
            &:before {
                background-color: transparent;
            }
        }
    }

</style>