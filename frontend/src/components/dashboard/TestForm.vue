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
    import factoryVisitorsService from "../../services/visitors/factoryVisitorsService";
    import {SESSIONS} from "../../configs/visitors/buttonTypes";
    export default {
        name: "TestForm",
        data() {
            return {
                result: ''
            };
        },
        created() {
            factoryVisitorsService.create(SESSIONS).fetchChartValues(1474221618, 1568829618,86000).then(res=>{
                this.result = res;
            });
        }
    };
</script>

<style scoped>

</style>