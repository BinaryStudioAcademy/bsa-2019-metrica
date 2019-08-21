<template>
    <VContent>
        <VFlex
            lg6
            md6
            sm12
            xs12
            :class="{'mx-5': $vuetify.breakpoint.smAndUp}"
        >
            <VContainer>
                <div
                    :key="res.percentage"
                    v-for="res in result"
                >
                    {{ res }}
                </div>
            </VContainer>
        </VFlex>
    </VContent>
</template>

<script>
    import newVisitorsService from "../../services/visitors/newVisitorsService";

    export default {
        name: "TestForm",
        data() {
            return {
                result: ''
            };
        },
        created() {
            newVisitorsService.fetchButtonValue(1474221618, 1568829618).then(res=>{
                this.result = res;
            });
            // newVisitorsService.fetchChartValues(1474221618, 1568829618,86400).then(res=>{
            //     this.result = res;
            // });
            // totalVisitorsService.fetchTableValues(1474221618, 1568829618, 'language').then(res => {
            //     this.result = res;
            // });

        }
    };
</script>

<style scoped>

</style>