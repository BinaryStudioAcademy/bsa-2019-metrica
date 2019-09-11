<template>
    <VContainer
        class="position-relative pa-0"
    >
        <Spinner v-if="isFetching" />
        <GroupedTable
            class="position-relative"
            :items="getItems"
            @change="changeGroupedParameter"
        >
            <span slot="total">
                {{ totalColumn }}
            </span>
            <span slot="percentage">
                {{ percentageColumn }}
            </span>
        </GroupedTable>
    </VContainer>
</template>

<script>
    import {visitorsHashMap} from "./visitorsHashMap.js";
    import GroupedTable from "./GroupedTable";
    import {mapGetters, mapActions} from 'vuex';
    import Spinner from '../../utilites/Spinner';
    import {
        GET_ACTIVE_BUTTON,
        GET_GROUPED_PARAMETER,
        GET_TABLE_DATA_ITEMS,
        GET_TABLE_DATA_FETCHING
    } from "@/store/modules/visitors/types/getters";
    import {
        CHANGE_FETCHED_TABLE_STATE,
        CHANGE_GROUPED_PARAMETER
    } from "@/store/modules/visitors/types/actions";

    export default {
        name: 'VisitorsTable',
        components: {
            GroupedTable,
            Spinner
        },
        computed: {
            ...mapGetters('visitors', {
                getActiveButton: GET_ACTIVE_BUTTON,
                getGroupedParameter: GET_GROUPED_PARAMETER,
                getItems: GET_TABLE_DATA_ITEMS,
                getFetchingState: GET_TABLE_DATA_FETCHING,

            }),
            totalColumn () {
                return (visitorsHashMap[this.activeButton] || {}).total;
            },
            percentageColumn () {
                return (visitorsHashMap[this.activeButton] || {}).percantage;
            },
            currentParameter () {
                return this.getGroupedParameter;
            },
            isFetching () {
                return this.getFetchingState;
            },
            activeButton () {
                return this.getActiveButton;
            }
        },
        methods: {
            ...mapActions('visitors', {
                changeFetchingTableState: CHANGE_FETCHED_TABLE_STATE,
                changeParameter: CHANGE_GROUPED_PARAMETER
            }),
            changeGroupedParameter (parameter) {
                if (this.currentParameter !== parameter) {
                    this.changeParameter(parameter);
                }
            }
        }
    };
</script>

<style scoped lang="scss">
    @media (max-width: 1500px) {
        ::v-deep .v-text-field__prefix {
            display: none;
        }
        ::v-deep .v-select__selections {
            padding-left: 16px;
        }
    }
</style>
