<template>
    <ContentLayout :title="title">
        <VLayout>
            <VFlex
                lg12
                md12
                hidden-sm-and-down
                height="100%"
                class="img-card"
            >
                <GroupedTable
                    :items="items"
                />
            </VFlex>
        </VLayout>
    </ContentLayout>
</template>

<script>
    import ContentLayout from '../components/layout/ContentLayout.vue';
    import GroupedTable from '../components/dashboard/geo_location/GroupedTable';

    export default {
        components: {
            GroupedTable,
            ContentLayout
        },
        data() {
            return {
                title: "Geo Location",
                items: [
                    {
                        country: 'World',
                        visitors: '175',
                        new_visitors: '50',
                        sessions: '331',
                        bounce_rate: '22.5%',
                        avg_session_time: '00:32:45'
                    },
                    {
                        country: 'USA',
                        visitors: '25',
                        new_visitors: '12',
                        sessions: '45',
                        bounce_rate: '14%',
                        avg_session_time: '00:30:00'
                    },
                    {
                        country: 'Ukraine',
                        visitors: '32',
                        new_visitors: '10',
                        sessions: '65',
                        bounce_rate: '21%',
                        avg_session_time: '00:37:00'
                    },
                    {
                        country: 'Canada',
                        visitors: '87',
                        new_visitors: '23',
                        sessions: '175',
                        bounce_rate: '5%',
                        avg_session_time: '00:43:00'
                    },
                    {
                        country: 'Japan',
                        visitors: '31',
                        new_visitors: '5',
                        sessions: '46',
                        bounce_rate: '49%',
                        avg_session_time: '00:21:00'
                    },
                ]
            };
        }
    };
</script>

<style scoped>

</style>