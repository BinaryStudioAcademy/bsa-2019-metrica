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
                <VSubheader class="body-1 grey--text text--darken-1 pa-0 mb-4">
                    Welcome to Metrica!
                </VSubheader>
                <VForm ref="form">
                    <label class="caption grey--text">
                        Email
                    </label>
                    <VTextField
                        name="email"
                        class="no-underline mt-5"
                        v-model="email"
                        type="text"
                        :rules="emailRules"
                        required
                    />
                </VForm>
                <VBtn
                    class="mt-9"
                    color="primary"
                    @click="onResetPassword"
                >
                    Send Password Reset Link
                </VBtn>
            </VContainer>
        </VFlex>
    </VContent>
</template>


<script>
    import {mapActions} from 'vuex';
    import {RESET_PASSWORD} from "@/store/modules/auth/types/actions";
    import { SHOW_SUCCESS_MESSAGE, SHOW_ERROR_MESSAGE } from "@/store/modules/notification/types/actions";

    export default {
        name: "ResetPasswordForm",
        data() {
            return {
                email: '',
                emailRules: [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
                ]
            };
        },
        methods: {
            ...mapActions('auth', {
                resetPassword: RESET_PASSWORD
            }),
            ...mapActions('notification', {
                showSuccessMessage: SHOW_SUCCESS_MESSAGE,
                showErrorMessage: SHOW_ERROR_MESSAGE
            }),
            onResetPassword() {
                if (this.$refs.form.validate()) {
                    this.resetPassword({
                        email: this.email,
                    }).then(response => {
                        this.showSuccessMessage(response);
                    }).catch(err => {
                        this.showErrorMessage(err);
                    });
                }
            }
        }

    };
</script>

<style lang="scss" scoped>
</style>