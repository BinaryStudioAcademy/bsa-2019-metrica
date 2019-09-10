<template>
    <VContent>
        <VFlex
            lg6
            md6
            sm12
            xs12
            :class="{'mx-5': $vuetify.breakpoint.smAndUp}"
        >
            <VContainer v-if="showEmail">
                <VSubheader class="body-1 grey--text text--darken-1 pa-0 mb-4">
                    Forgot your password? Please enter your email address and we'll send you a link to reset your password
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
                    :disabled="sending"
                    @click="onResetPassword"
                >
                    Reset password
                </VBtn>
                <VAlert
                    class="error-response"
                    v-if="hasError"
                    type="error"
                    v-html="errorMsg"
                />
            </VContainer>
            <VContainer v-else>
                <VAlert
                    class="success-response"
                    type="success"
                >
                    <span v-html="successMsg" />
                </VAlert>
            </VContainer>
        </VFlex>
    </VContent>
</template>


<script>
    import {mapActions} from 'vuex';
    import {RESET_PASSWORD} from "@/store/modules/auth/types/actions";
    import {validateEmail} from '@/services/validation';

    export default {
        name: "ResetPasswordForm",
        data() {
            return {
                email: '',
                emailRules: [
                    v => !!v || 'E-mail is required',
                    v => validateEmail(v) || 'E-mail must be valid',
                ],
                showEmail: true,
                hasError:false,
                successMsg:'',
                errorMsg:'',
                sending:false
            };
        },
        methods: {
            ...mapActions('auth', {
                resetPassword: RESET_PASSWORD
            }),
            onResetPassword() {
                if (this.$refs.form.validate()) {
                    this.hasError=false;
                    this.sending = true;
                    this.resetPassword({
                        email: this.email,
                    }).then((response) => {
                        this.showEmail = false;
                        this.successMsg = response;
                    }).catch(err => {
                        this.hasError = true;
                        this.errorMsg = err;
                    }).finally(()=>{
                        this.sending = false;
                    });
                }
            }
        }

    };
</script>

<style lang="scss" scoped>
    .success-response{
        margin-top: 100px;
        min-width: 245px;
        max-width: 712px;
    }

    .error-response{
        margin-top: 25px;
    }
</style>