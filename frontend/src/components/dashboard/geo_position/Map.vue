<template>
    <div class="container">
        <GChart
            type="GeoChart"
            :data="chartData"
            :options="chartOptions"
            class="map"
        />
    </div>
</template>


<script>
    import { GChart } from 'vue-google-charts';

    export default {
        components: {
            GChart
        },
        data() {
            return {
                chartData: [
                    ['Country', 'Popularity'],
                    ['Germany', 200],
                    ['United States', 300],
                    ['Brazil', 400],
                    ['Canada', 500],
                    ['France', 600],
                    ['UA', 700]
                ],
                chartOptions: {
                    colorAxis: {colors: ['#D4DAF8', '#3C57DE']},
                    datalessRegionColor: '#ECF3FF'
                }
            };
        }
    };

</script>

<style>
</style>