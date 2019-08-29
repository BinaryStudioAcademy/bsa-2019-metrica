<template>
    <VContainer
        clas="position-relative"
    >
        <Spinner v-if="isFetching" />
        <GroupedTable
            class="position-relative"
            :items="items"
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
    import moment from 'moment';

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
            items() {
                if (this.activeButton === 'avg_session') {
                    return this.getItems.map((item) => {
                        return { ...item, total: moment.unix(item.total).format("HH:mm:ss")};
                    });
                }
                return this.getItems;
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
