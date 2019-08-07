<template>
    <v-content>
                <v-flex
                       lg6
                       md6
                       sm12
                       xs12
                >
                    <v-container>
                        <v-card-text class="login-container">
                            <v-subheader
                                    class="login-form-header"
                            >Welcome to Metrica!</v-subheader>
                            <v-form
                                    ref="form"
                            >
                                <v-subheader
                                        class="login-form-label"
                                >Email</v-subheader>
                                <v-text-field
                                        name="email"
                                        class="login-form-input"
                                        v-model="email"
                                        solo
                                        type="text"
                                        :rules="emailRules"
                                        required
                                >
                                </v-text-field>

                                <v-subheader
                                        class="login-form-label"
                                >Password</v-subheader>
                                <v-text-field
                                        name="password"
                                        class="login-form-input"
                                        v-model="password"
                                        solo
                                        type="password"
                                        :rules="passwordRules"
                                        required
                                >
                                </v-text-field>
                            </v-form>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn @click="onLogin" class="login-form-button mt-3" color="#3C57DE">Login</v-btn>
                        </v-card-actions>
                    </v-container>
                </v-flex>
    </v-content>
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        data () {
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
            ...mapActions({
                login: 'auth/login'
            }),
            onLogin () {
                if (this.$refs.form.validate()) {
                    this.login({
                        email: this.email,
                        password: this.password
                    }).then(res => {

                    }, err => {
                        console.log(err);
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

    .login-form-input{
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