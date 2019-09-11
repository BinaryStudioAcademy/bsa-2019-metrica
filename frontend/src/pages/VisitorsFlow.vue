<template>
    <ContentLayout
        :title="title"
    >
        <Spinner
            v-if="isFetching"
        />
        <VisitorsFlowDropdown
            :value="getSelectedParameter"
        />
        <VisitorsFlowDiagram />
    </ContentLayout>
</template>

<script>
    import ContentLayout from '@/components/layout/ContentLayout.vue';
    import VisitorsFlowDiagram from "@/components/dashboard/visitors_flow/VisitorsFlowDiagram";
    import VisitorsFlowDropdown from "@/components/dashboard/visitors_flow/VisitorsFlowDropdown";
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
        FETCH_VISITORS_FLOW
    } from "@/store/modules/visitors_flow/types/actions";

    export default {
        name: "VisitorsFlow",
        components: {
            ContentLayout,
            VisitorsFlowDiagram,
            VisitorsFlowDropdown,
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
            this.fetchVisitorsFlow();
        },
        methods: {
            ...mapActions('visitors_flow', {
                changeSelectedParameter: CHANGE_SELECTED_PARAMETER,
                fetchVisitorsFlow: FETCH_VISITORS_FLOW
            }),
        }
    };
</script>

<style scoped>

</style>