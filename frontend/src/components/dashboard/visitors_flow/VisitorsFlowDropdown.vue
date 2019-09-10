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
                    {title: 'Country', value: 'country'},
                    {title: 'Browser', value: 'browser'},
                    {title: 'Device', value: 'device'},
                    {title: 'Screen', value: 'screen'}
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