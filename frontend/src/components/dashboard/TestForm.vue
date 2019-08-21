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
                <div>{{ result }}</div>
            </VContainer>
        </VFlex>
    </VContent>
</template>

<script>
    import totalVisitorsService from "../../services/visitors/totalVisitorsSevice";
    export default {
        name: "TestForm",
        data() {
            return {
                result: ''
            };
        },
        created() {
            totalVisitorsService.fetchButtonValue(1564697460, 1565467638).then(res=>alert(res.value));
        }
    };
</script>

<style scoped>

</style>