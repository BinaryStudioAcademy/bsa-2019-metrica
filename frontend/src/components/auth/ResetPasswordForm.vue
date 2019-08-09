<template>
    <VContent>
        <VFlex
            lg6
            md6
            sm12
            xs12
        >
            <VContainer>
                <VCardText>
                    <VSubheader class="reset-password-form-header">
                        Welcome to Metrica!
                    </VSubheader>
                    <VForm ref="form">
                        <VSubheader class="reset-password-form-label">
                            Email
                        </VSubheader>
                        <VTextField
                            name="email"
                            class="reset-password-form-input"
                            v-model="email"
                            solo
                            type="text"
                            :rules="emailRules"
                            required
                        />
                    </VForm>
                </VCardText>
                <VCardActions>
                    <VBtn
                        class="reset-password-form-button mt-3"
                        color="#3C57DE"
                        @click="onResetPassword"
                    >
                        Send Password Reset Link
                    </VBtn>
                </VCardActions>
                <VAlert
                    :class="className"
                    v-if="showAlert"
                    :type="type"
                >
                    {{ message }}
                </VAlert>
            </VContainer>
        </VFlex>
    </VContent>
</template>


<script>
    import {mapActions} from 'vuex';
    import {RESET_PASSWORD} from "@/store/modules/auth/types/actions";

    export default {
        name: "ResetPasswordForm",
        data() {
            return {
                email: '',
                emailRules: [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
                ],
                status: '',
                message: ''
            }
        },
        computed: {
            showAlert: function () {
                return this.status === 'success' || this.status === 'error';
            },
            type: function () {
                return this.status === 'success' ? 'success' : 'error';
            },
            className: function () {
                return this.status === 'success' ? 'status-success' : 'status-error';
            }
        },
        methods: {
            ...mapActions('auth', {
                resetPassword: RESET_PASSWORD
            }),
            onResetPassword() {
                if (this.$refs.form.validate()) {
                    this.resetPassword({
                        email: this.email,
                    }).then(response => {
                        this.status = 'success';
                        this.message = response;
                    }).catch(err => {
                        this.status = 'error';
                        this.message = err;
                    });
                }
            }
        }

    }
</script>

<style lang="scss" scoped>
    .reset-password-form-header {
        font-size: 16px;
        line-height: 19px;
        display: flex;
        align-items: center;
        letter-spacing: 0.4px;
        font-weight: bold;
        color: #122737;
    }

    .reset-password-form-label {
        box-sizing: border-box;
        margin-top: 26px;
        font-size: 12px;
        line-height: 15px;
        display: flex;
        align-items: center;
        letter-spacing: 0.4px;
        color: rgba(18, 39, 55, 0.5);
    }

    .reset-password-form-input {
        max-width: 426px;
        height: 37px;
        border: 1px solid rgba(18, 39, 55, 0.11);
        border-radius: 3px;
        background: #FFFFFF;
        box-sizing: border-box;

        ::v-deep {
            .v-input__control {
                min-height: 1px;
            }

            input {
                min-height: 36px;
                -webkit-box-shadow: inset 0 0 0 9999px white !important;
            }
        }

        &.v-input--is-focused {
            border: 1px solid rgba(60, 87, 222, 0.52);
            box-shadow: 0px 0px 14px rgba(194, 205, 223, 0.6);
        }
    }

    .reset-password-form-button {
        color: white;
        border: 1px solid rgba(18, 39, 55, 0.11);
        box-sizing: border-box;
        border-radius: 3px;
        max-width: 208px;

        ::v-deep {
            span {
                font-size: 12px;
                line-height: 15px;
                display: flex;
                align-items: center;
                text-align: center;
                letter-spacing: 0.4px;
                text-transform: uppercase;
                color: #FFFFFF;
            }
        }
    }

    .v-subheader {
        padding: 0;
    }

    .v-card__actions {
        box-sizing: border-box;
        padding: 8px 16px;
    }

    .status-success, .status-error {
        padding: 8px;
        margin: 8px 0 0 12px;
        max-width: 550px;
    }
</style>