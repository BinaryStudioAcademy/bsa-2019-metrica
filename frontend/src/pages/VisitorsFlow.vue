<template>
    <ContentLayout
        :title="title"
    >
        <Spinner
            v-if="isFetching"
        />
        <template v-if="getVisitorsFlow.length !== 0">
            <VisitorsFlowDropdown
                :value="getSelectedParameter"
                @change="changeSelectedParameter"
            />
            <VisitorsFlowDiagram
                :visitors-flow-data="getVisitorsFlow"
                @add-interaction="addInteraction"
            />
        </template>
        <NoData v-else />
    </ContentLayout>
</template>

<script>
    import ContentLayout from '@/components/layout/ContentLayout.vue';
    import VisitorsFlowDiagram from "@/components/dashboard/visitors_flow/VisitorsFlowDiagram";
    import VisitorsFlowDropdown from "@/components/dashboard/visitors_flow/VisitorsFlowDropdown";
    import NoData from "@/components/dashboard/visitors_flow/NoData";
    import Spinner from "@/components/utilites/Spinner";
    import { mapGetters, mapActions } from 'vuex';
    import {
        GET_SELECTED_PARAMETER,
        GET_CURRENT_LEVEL,
        GET_VISITORS_FLOW,
        IS_FETCHING
    } from "@/store/modules/visitors_flow/types/getters";
    import {
        CHANGE_SELECTED_PARAMETER,
        CHANGE_CURRENT_LEVEL,
        FETCH_AND_SET_VISITORS_FLOW,
        FETCH_AND_PUSH_VISITORS_FLOW
    } from "@/store/modules/visitors_flow/types/actions";

    export default {
        name: "VisitorsFlow",
        components: {
            ContentLayout,
            VisitorsFlowDiagram,
            VisitorsFlowDropdown,
            NoData,
            Spinner
        },
        data () {
            return {
                title: "Visitors Flow"
            };
        },
        computed: {
            ...mapGetters('visitors_flow', {
                getSelectedParameter: GET_SELECTED_PARAMETER,
                getCurrentLevel: GET_CURRENT_LEVEL,
                getVisitorsFlow: GET_VISITORS_FLOW,
                isFetching: IS_FETCHING
            })
        },
        created() {
            this.fetchAndSetVisitorsFlow();
        },
        methods: {
            ...mapActions('visitors_flow', {
                changeSelectedParameter: CHANGE_SELECTED_PARAMETER,
                changeCurrentLevel: CHANGE_CURRENT_LEVEL,
                fetchAndSetVisitorsFlow: FETCH_AND_SET_VISITORS_FLOW,
                fetchAndPushVisitorsFlow: FETCH_AND_PUSH_VISITORS_FLOW
            }),
            addInteraction (level) {
                this.changeCurrentLevel(level);
                this.fetchAndPushVisitorsFlow();
            }
        }
    };
</script>

<style scoped>

</style>