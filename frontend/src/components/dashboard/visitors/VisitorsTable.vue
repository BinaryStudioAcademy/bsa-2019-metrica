<template>
    <GroupedTable
        :items="tableData"
        @change="changeTable"
    />
</template>

<script>
    import visitorsHashMap from "./visitorsHashMap";
    import GroupedTable from "./GroupedTable";
    import {mapGetters} from 'vuex';
    import {GET_ACTIVE_BUTTON} from "@/store/modules/visitors/types/getters";

    export default {
        name: 'VisitorsTable',
        components: {
            GroupedTable
        },
        computed: {
            ...mapGetters('visitors', {
                activeButton: GET_ACTIVE_BUTTON
            }),
            totalColumn () {
                return (visitorsHashMap[this.activeButton] || {}).total;
            },
            percentageColumn () {
                return (visitorsHashMap[this.activeButton] || {}).percentage;
            }
        }
    };
</script>