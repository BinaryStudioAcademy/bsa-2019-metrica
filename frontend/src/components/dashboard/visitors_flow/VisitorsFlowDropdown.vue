<template>
    <DefaultDropdown
        :items="items"
        :value="value"
        @change="change"
    />
</template>

<script>
    import DefaultDropdown from '@/components/common/DefaultDropdown';

    export default {
        name: "VisitorsFlowDropdown",
        components: {
            DefaultDropdown
        },
        props: {
            value: {
                type: String,
                required: true
            },
        },
        data () {
            return {
                items: [
                    {title: 'Country', value: 'Country'},
                    {title: 'Browser', value: 'Browser'},
                    {title: 'Device', value: 'Device'},
                    {title: 'Screen', value: 'Screen'}
                ]
            };
        },
        methods: {
            change(selectedItem) {
                this.$emit("change", selectedItem);
            }
        }
    };
</script>

<style scoped>

</style>