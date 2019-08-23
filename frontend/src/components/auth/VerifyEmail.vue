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
    import jwtService from "@/services/jwtService";
    import requestService from "@/services/requestService";
    import config from "@/config";
    import {mapActions} from 'vuex';
    import {SHOW_SUCCESS_MESSAGE, SHOW_ERROR_MESSAGE} from "@/store/modules/notification/types/actions";
    import _ from 'lodash';

    const resourceUrl = config.getApiUrl() + '/auth/confirm-email';

    export default {
        name: "VerifyEmail",
        data() {
            return {
                error: false,
            };
        },
        created() {
            let token = jwtService.parse(this.$route.query.token);
            if (token.exp < Date.now().valueOf() / 1000) {
                this.error = true;
            } else {
                requestService.update(resourceUrl, {
                    token: this.$route.query.token
                }).then((response) => {
                    this.showSuccessMessage(response.data.message);
                    this.$router.push({name: 'login'});
                }).catch(error => {
                    this.showErrorMessage(_.get(error, 'response.data.error.message'));
                    this.$router.push({name: 'login'});
                });
            }
        },
        methods: {
            ...mapActions('notification', {
                showSuccessMessage: SHOW_SUCCESS_MESSAGE,
                showErrorMessage: SHOW_ERROR_MESSAGE
            }),
        }
    };
</script>

<style scoped>

</style>