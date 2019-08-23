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
                <VAlert
                    type="error"
                    v-if="error"
                >
                    Sorry, your token was expired. Please, register again.
                </VAlert>
            </VContainer>
        </VFlex>
    </VContent>
</template>

<script>
    import jwtService from "../../services/jwtService";
    import requestService from "../../services/requestService";
    import config from "@/config";

    const resourceUrl = config.getApiUrl()+'/auth/confirm-email';

    export default {
        name: "VerifyEmail",
        data() {
            return {
                token: '',
                expr: '',
                error: false,
                curTime: ''
            };
        },
        created() {
            this.token = jwtService.parse(this.$route.query.token);
            if (this.token.exp < Date.now().valueOf() / 1000) {
                this.error = true;
            } else {
                requestService.update(resourceUrl, {
                    token: this.$route.query.token
                }).then(res=>alert(res));
            }
        }
    };
</script>

<style scoped>

</style>