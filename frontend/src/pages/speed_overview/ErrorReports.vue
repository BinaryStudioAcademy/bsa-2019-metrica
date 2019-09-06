<template>
    <ContentLayout :title="title">
        <VRow class="position-relative">
            <Spinner v-if="fetching" />
            <ErrorsTable
                :error-items="tableData.items"
                :fetching="tableData.isFetching"
                @change="changeGroupedParameter"
            />
        </VRow>
    </ContentLayout>
</template>

<script>
    import ContentLayout from '../../components/layout/ContentLayout.vue';
    import ErrorsTable from '../../components/dashboard/errors/ErrorsTable.vue';
    import { isWebsite } from "../../mixins/isWebsite";
    import Spinner from '../../components/utilites/Spinner';


    export default {
        name: "ErrorReports",
        components: {
            ContentLayout,
            ErrorsTable,
            Spinner
        },
        mixins: [isWebsite],
        data() {
            return {
                title: "Error Reports",
                current_paremeter: 'page',
                tableData: {
                    isFetching: false,
                    items: [
                        {
                            parameter_value: '/contacts',
                            page: '/contacts',
                            message: 'SyntaxError',
                            page_views: 45
                        },
                        {
                            parameter_value: '/home',
                            page: '/home',
                            message: 'ReferenceError',
                            page_views: 34
                        },
                        {
                            parameter_value: '/products',
                            page: '/products',
                            message: 'TypeError',
                            page_views: 12
                        },
                        {
                            parameter_value: '/user',
                            page: '/user',
                            message: 'InternalError',
                            page_views: 3
                        }
                    ]
                }
            };
        },
        methods: {
            changeGroupedParameter (parameter) {
                if (this.currentParameter !== parameter) {
                    this.currentParameter = parameter;
                }
            }
        }
    };
</script>

<style scoped>

</style>
