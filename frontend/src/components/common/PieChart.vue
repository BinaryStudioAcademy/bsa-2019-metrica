<template>
    <GChart
        type="PieChart"
        :data="chartData"
        :options="chartOptions"
    />
</template>

<script>
    import {GChart} from 'vue-google-charts'

    export default {
        components: {
            GChart
        },
        props: {
            title: {
                type: String,
                default: 'PieChart'
            },
            data: {
                type: Array,
                default: () => []
            },
            pieHole: {
                type: Number,
                default: 0.9
            }
        },
        data() {
            return {
                chartData: this.data,
                chartOptions: {
                    title: this.title,
                    pieHole: this.pieHole
                }
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>