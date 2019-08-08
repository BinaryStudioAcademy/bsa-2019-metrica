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
                    <VBtn @click="onResetPassword" class="reset-password-form-button mt-3" color="#3C57DE">
                        Send Password Reset Link
                    </VBtn>
                </VCardActions>
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
                        alert(response.status)
                    }, err => {
                        alert(err.message);
                    })
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

        /*background: #3C57DE!important;*/
        /*border: 1px solid rgba(18, 39, 55, 0.11);*/
        /*box-sizing: border-box;*/
        /*border-radius: 3px;*/
        /*:v-deep {*/
        /*    span {*/
        /*        color:#ffffff;*/
        /*        font-size: 12px;*/
        /*        line-height: 15px;*/
        /*        padding: 7px 21px 7px 21px;*/
        /*        font-weight: bold;*/
        /*    }*/
        /*}*/
        /*span.v-btn__content {*/
        /*    font-size: 12px;*/
        /*    line-height: 15px;*/
        /*    display: flex;*/
        /*    align-items: center;*/
        /*    text-align: center;*/
        /*    letter-spacing: 0.4px;*/
        /*    text-transform: uppercase;*/
        /*    color: #FFFFFF!important;*/
        /*}*/
    }

    .v-subheader {
        padding: 0;
    }

    .v-card__actions {
        box-sizing: border-box;
        padding: 8px 16px;
    }
</style>