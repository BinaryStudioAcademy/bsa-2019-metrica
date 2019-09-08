<template>
    <DefaultDropdown
        class="option-select"
        :items="items"
        :value="value"
        @change="changeWebsite"
    />
</template>

<script>
    import DefaultDropdown from '@/components/common/DefaultDropdown';

    export default {
        name: "WebsitesDropdown",
        components: {
            DefaultDropdown
        },
        props: {
            value: {
                type:String,
                required: true
            },
            items: {
                type:Array,
                required: true
            }
        },
        methods: {
            changeWebsite(selectedItem) {
                this.$emit("change", selectedItem);
            },
        }
    };
</script>

<style lang="scss" scoped>
    .option-select {
        padding: 0;
        max-width: 250px;
        max-height: 34px;
    }
</style>
