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
        props: {
            dataItems: {
                type: Array,
                required: true
            }
        },
        data() {
            return {
                chartParameter: 'visitors',
                chartOptions: {
                    colorAxis: {colors: ['#D4DAF8', '#3C57DE']},
                    datalessRegionColor: '#ECF3FF'
                }
            };
        },
        computed: {
            chartData () {
                let dataArray = [['Country', this.chartParameter]];
                this.dataItems.map((item) => {
                    dataArray.push([item.country, +item[this.chartParameter]]);
                });
                return dataArray;
            }
        }
    };

</script>

<style>
</style>