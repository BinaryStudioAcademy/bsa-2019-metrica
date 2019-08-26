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
                <MapButtons />
                <MapChart
                    :parameter="getSelectedParameter"
                    :data-items="geoLocationItems"
                />
                <PeriodDropdown
                    :value="getSelectedPeriod"
                    @change="changeSelectedPeriod"
                />
            </VFlex>
            <VFlex
                xl4
                lg4
                md12
            >
                <MapList
                    :displayed-parameter="getSelectedParameter"
                    :data-items="geoLocationItems"
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
                    :items="geoLocationItems"
                />
            </VFlex>
        </VLayout>
    </ContentLayout>
</template>

<script>
    import MapButtons from "../components/dashboard/geo_location/MapButtons";
    import MapList from "../components/dashboard/geo_location/MapList";
    import ContentLayout from '../components/layout/ContentLayout.vue';
    import GroupedTable from '../components/dashboard/geo_location/GroupedTable';
    import MapChart from '../components/dashboard/geo_location/MapChart';
    import PeriodDropdown from "../components/dashboard/common/PeriodDropdown.vue";
    import {mapGetters, mapActions} from 'vuex';
    import {GET_SELECTED_PERIOD, GET_SELECTED_PARAMETER} from "@/store/modules/geo_location/types/getters";
    import {CHANGE_SELECTED_PERIOD} from "@/store/modules/geo_location/types/actions";
    import {FETCH_GEO_LOCATION_ITEMS} from "@/store/modules/geo_location/types/actions";
    import {GET_GEO_LOCATION_ITEMS} from "@/store/modules/geo_location/types/getters";

    export default {
        components: {
            GroupedTable,
            ContentLayout,
            MapChart,
            PeriodDropdown,
            MapButtons,
            MapList
        },
        created() {
            this.fetchGeoLocationItems();
        },
        data() {
            return {
                title: "Geo Location",
                /*items: [
                    {
                        country: 'US',
                        visitors: '1',
                        new_visitors: '12',
                        sessions: '10',
                        bounce_rate: '88',
                        avg_session_time: '00:30:00'
                    },
                    {
                        country: 'Canada',
                        visitors: '48',
                        new_visitors: '12',
                        sessions: '67',
                        bounce_rate: '14',
                        avg_session_time: '00:30:00'
                    },
                    {
                        country: 'Ukraine',
                        visitors: '32',
                        new_visitors: '10',
                        sessions: '32',
                        bounce_rate: '21',
                        avg_session_time: '00:37:00'
                    },
                    {
                        country: 'Brazil',
                        visitors: '87',
                        new_visitors: '23',
                        sessions: '175',
                        bounce_rate: '45',
                        avg_session_time: '00:43:00'
                    },
                    {
                        country: 'Germany',
                        visitors: '65',
                        new_visitors: '23',
                        sessions: '10',
                        bounce_rate: '5',
                        avg_session_time: '00:43:00'
                    },
                    {
                        country: 'Japan',
                        visitors: '31',
                        new_visitors: '5',
                        sessions: '46',
                        bounce_rate: '12',
                        avg_session_time: '00:21:00'
                    },
                ]*/
            };
        },
        computed: {
            ...mapGetters('geo_location', {
                getSelectedPeriod: GET_SELECTED_PERIOD,
                getSelectedParameter: GET_SELECTED_PARAMETER,
                getGeoLocationItems: GET_GEO_LOCATION_ITEMS
            }),
            geoLocationItems: () => this.getGeoLocationItems()
        },
        methods: {
            ...mapActions('geo_location', {
                changeSelectedPeriod: CHANGE_SELECTED_PERIOD,
                fetchGeoLocationItems: FETCH_GEO_LOCATION_ITEMS
            }),
        }
    };
</script>

<style scoped>
    .map-container {
        background-color: white;
        padding: 30px 40px;
    }
</style>