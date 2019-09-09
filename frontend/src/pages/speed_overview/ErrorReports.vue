<template>
    <ContentLayout :title="title">
        <VRow class="position-relative">
            <Spinner v-if="tableData.isFetching" />
            <ErrorsTable
                @open="openModal"
                :error-items="tableData.items"
                @change="changeGroupedParameter"
            />
        </VRow>
        <ErrorsDetailsModal
            :dialog="dialog"
            :error-item="modalItem"
            @close="dialog = false"
        />
    </ContentLayout>
</template>

<script>
    import ContentLayout from '../../components/layout/ContentLayout.vue';
    import ErrorsTable from '../../components/dashboard/errors/ErrorsTable.vue';
    import { isWebsite } from "../../mixins/isWebsite";
    import Spinner from '../../components/utilites/Spinner';
    import ErrorsDetailsModal from '../../components/dashboard/errors/ErrorsDetailsModal';


    export default {
        name: "ErrorReports",
        components: {
            ContentLayout,
            ErrorsDetailsModal,
            ErrorsTable,
            Spinner
        },
        mixins: [isWebsite],
        data() {
            return {
                dialog:false,
                modalItem:{
                    message: 'message'
                },
                title: "Error Reports",
                current_paremeter: 'page',
                tableData: {
                    isFetching: false,
                    items: [
                        {
                            parameter_value: '/contacts',
                            page: '/contacts',
                            message: 'SyntaxError',
                            stack_trasce: 'at Object.device.tablet (metrica.js?tracking_id=00000186:317)\n' +
                                'at Object.device.desktop (metrica.js?tracking_id=00000186:325)\n' +
                                'at Object.getDevice (metrica.js?tracking_id=00000186:130)',
                            page_views: 45
                        },
                        {
                            parameter_value: '/home',
                            page: '/home',
                            message: 'ReferenceError',
                            stack_trace: 'at Object.device.tablet (metrica.js?tracking_id=00000186:317)\n' +
                                'at Object.device.desktop (metrica.js?tracking_id=00000186:325)\n' +
                                'at Object.getDevice (metrica.js?tracking_id=00000186:130)',
                            page_views: 34
                        },
                        {
                            parameter_value: '/products',
                            page: '/products',
                            message: 'TypeError',
                            stack_trace: 'at Object.device.tablet (metrica.js?tracking_id=00000186:317)\n' +
                                'at Object.device.desktop (metrica.js?tracking_id=00000186:325)\n' +
                                'at Object.getDevice (metrica.js?tracking_id=00000186:130)',
                            page_views: 12
                        },
                        {
                            parameter_value: '/user',
                            page: '/user',
                            message: 'InternalError',
                            stack_trace: 'at Object.device.tablet (metrica.js?tracking_id=00000186:317)\n' +
                                'at Object.device.desktop (metrica.js?tracking_id=00000186:325)\n' +
                                'at Object.getDevice (metrica.js?tracking_id=00000186:130)',
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
            },
            openModal(item) {
                this.dialog = true;
                this.modalItem = {
                    ...this.modalItem,
                    ...item
                };
            }
        }
    };
</script>

<style scoped>

</style>
