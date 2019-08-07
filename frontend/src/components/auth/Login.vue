<template>
    <VContent>
        <VFlex
            lg6
            md6
            sm12
            xs12
        >
            <VContainer>
                <VCardText
                    class="login-container">
                    <VSubheader
                        class="login-form-header"
                    >Welcome to Metrica!
                    </VSubheader>
                    <VForm
                        ref="form"
                    >
                        <VSubheader
                            class="login-form-label"
                        >Email
                        </VSubheader>
                        <VTextField
                            name="email"
                            class="login-form-input"
                            v-model="email"
                            solo
                            type="text"
                            :rules="emailRules"
                            required
                        />

                        <VSubheader
                            class="login-form-label"
                        >Password
                        </VSubheader>
                        <VTextField
                            name="password"
                            class="login-form-input"
                            v-model="password"
                            solo
                            type="password"
                            :rules="passwordRules"
                            required
                        />
                    </VForm>
                </VCardText>
                <VCardActions>
                    <VBtn @click="onLogin" class="login-form-button mt-3" color="#3C57DE">Login</VBtn>
                </VCardActions>
            </VContainer>
        </VFlex>
    </VContent>
</template>

<script>
    import {mapActions} from 'vuex';
    import {LOGIN} from "@/store/modules/auth/types/actions";

    export default {
        data() {
            return {
                email: '',
                password: '',
                valid: false,
                emailRules: [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
                ],
                passwordRules: [
                    v => !!v || 'Password is required',
                    v => (v && v.length >= 6) || 'Password must be equal or more than 6 characters'
                ]
            }
        },
        methods: {
            ...mapActions('auth', {
                login: LOGIN
            }),
            onLogin() {
                if (this.$refs.form.validate()) {
                    this.login({
                        email: this.email,
                        password: this.password
                    }).then(res => {
                        this.$router.push({path: '/'});
                    }, err => {
                        alert(err.message);
                    })
                }
            }
        }
    }
</script>

<style scoped>
    .login-form-input >>> .v-input__control {
        min-height: 1px;
    }

    .login-form-input.v-input--is-focused {
        border: 1px solid rgba(60, 87, 222, 0.52);
        box-shadow: 0px 0px 14px rgba(194, 205, 223, 0.6);
    }

    .login-form-input {
        height: 37px;
        border: 1px solid rgba(18, 39, 55, 0.11);
        border-radius: 3px;
    }

    .login-form-input >>> input {
        min-height: 35px;
    }

    .login-form-input >>> .v-input__prepend-outer {
        margin-top: 4px;
    }

    .login-form-label {
        padding: 0;
        color: rgba(18, 39, 55, 0.5);
        font-size: 12px;
        height: 28px;
        margin-top: 25px;
        font-weight: bold;
    }

    .login-form-header {
        font-size: 16px;
        line-height: 19px;
        font-weight: bold;
        color: #122737;
        padding: 0;

    }

    .login-container {
        padding: 8px;
    }

    .login-form-button {
        color: white;
    }

    .login-form-button >>> span {
        font-size: 12px;
        line-height: 15px;
        padding: 7px 21px 7px 21px;
        font-weight: bold;
    }
</style>