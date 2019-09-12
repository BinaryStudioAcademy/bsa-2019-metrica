<template>
    <div
        v-if="showEmail"
        class="form"
    >
        <h3 class="title grey--text text--darken-1 mb-8 mt-6">
            Forgot your password?
        </h3>
        <VSubheader class="instruction body-2 px-0 grey--text text--darken-1 mb-5">
            Please enter your email address and we'll send you a link to reset your password.
        </VSubheader>
        <VForm ref="form">
            <label class="caption grey--text">
                Email
            </label>
            <VTextField
                name="email"
                class="no-underline mt-1"
                solo
                v-model="email"
                type="text"
                :rules="emailRules"
                required
            />
        </VForm>
        <VBtn
            class="mt-4"
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
    </div>
    <VContainer v-else>
        <VAlert
            class="success-response"
            type="success"
        >
            Check your inbox. We just sent a link to reset your password via email {{ email }}. Back to
            <RouterLink
                class="forgot-password-link"
                :to="{name: 'login'}"
            >
                sign in
            </RouterLink>
        </VAlert>
    </VContainer>
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
                    }).then(() => {
                        this.showEmail = false;
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
    .v-subheader.instruction,
    .v-text-field {
        font-family: GilroySemiBold;
    }
    .success-response {
        margin-left: 40px;
        min-width: 245px;
        max-width: 712px;
    }

    .error-response{
        margin-top: 25px;
    }

    .form {
        width: 50%;
    }
</style>