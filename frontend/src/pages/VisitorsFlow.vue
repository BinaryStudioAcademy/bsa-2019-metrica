<template>
    <div>
        <VisitorsFlowDropdown
            value="Country"
        />
        <VisitorsFlowDiagram />
    </div>
</template>

<script>
    import VisitorsFlowDiagram from "@/components/dashboard/visitors_flow/VisitorsFlowDiagram";
    import VisitorsFlowDropdown from "@/components/dashboard/visitors_flow/VisitorsFlowDropdown";

    export default {
        name: "VisitorsFlow",
        components: {
            VisitorsFlowDiagram,
            VisitorsFlowDropdown
        }
    };
</script>

<style scoped>

</style>