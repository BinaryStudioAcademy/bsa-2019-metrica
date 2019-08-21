<template>
    <GroupedTable
        :items="tableData"
        @change="changeTable"
    />
</template>

<script>
    import visitorsHashMap from "./visitorsHashMap";
</script>