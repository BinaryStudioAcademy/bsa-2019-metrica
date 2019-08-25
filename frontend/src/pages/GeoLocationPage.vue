<template>
    <ContentLayout :title="title">
        <VLayout
            class="map-container"
        >
            <VFlex
                xl8
                lg8
                md12
                height="100%"
                class="img-card"
            >
                <Map
                    :data-items="items"
                />
                <PeriodDropdown
                    :value="getSelectedPeriod"
                    @change="changePeriod"
                />
            </VFlex>
        </VLayout>
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
    import Map from '../components/dashboard/geo_location/Map';
    import PeriodDropdown from "../components/dashboard/common/PeriodDropdown.vue";
    import {mapGetters, mapActions} from 'vuex';
    import {GET_SELECTED_PERIOD} from "@/store/modules/geo_location/types/getters";
    import {CHANGE_SELECTED_PERIOD} from "@/store/modules/geo_location/types/actions";

    export default {
        components: {
            GroupedTable,
            ContentLayout,
            Map,
            PeriodDropdown
        },
        data() {
            return {
                title: "Geo Location",
                items: [
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
        },
        computed: {
            ...mapGetters('geo_location', {
                getSelectedPeriod: GET_SELECTED_PERIOD,
            }),
        },
        methods: {
            ...mapActions('geo_location', {
                changeSelectedPeriod: CHANGE_SELECTED_PERIOD
            }),
            changePeriod(data) {
                this.changeSelectedPeriod(data);
            }
        }
    };
</script>

<style scoped>
    .map-container {
        background-color: white;
    }
</style>