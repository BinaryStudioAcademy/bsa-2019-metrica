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
                <div>
                    <h3> 'hello!'</h3>
                    <div>Токен {{ $route.params.token }}</div>
                </div>
            </VContainer>
        </VFlex>
    </VContent>
</template>

<script>
    export default {
        name: "VerifyEmail",
        data(){

        }
    };
</script>

<style scoped>

</style>