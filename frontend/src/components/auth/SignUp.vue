<template>
    <v-container
            fluid
            fill-height
    >
        <v-layout
                align-center
                justify-center
        >
            <v-flex
                    xs12
                    sm8
                    md6
            >
                <v-card class="elevation-12">
                    <v-toolbar
                            dark
                            color="primary"
                    >
                        <v-toolbar-title>
                            Welcome to Metrica!
                        </v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>
                        <v-form
                                v-model="valid"
                                ref="form"
                                lazy-validation
                        >
                            <v-text-field
                                    prepend-icon="person"
                                    name="name"
                                    label="Full name"
                                    type="name"
                                    v-model="name"
                                    :rules="nameRules"
                            ></v-text-field>
                            <v-text-field
                                    prepend-icon="email"
                                    name="email"
                                    label="Email"
                                    type="email"
                                    v-model="email"
                                    :rules="emailRules"
                            ></v-text-field>
                            <v-text-field
                                    prepend-icon="lock"
                                    name="password"
                                    label="Password"
                                    type="password"
                                    :counter="6"
                                    v-model="password"
                                    :rules="passwordRules"
                            ></v-text-field>
                            <v-text-field
                                    prepend-icon="lock"
                                    name="confirm-password"
                                    label="Confirm password"
                                    type="password"
                                    :counter="6"
                                    v-model="confirmPassword"
                                    :rules="confirmPasswordRules"
                            ></v-text-field>
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                                color="primary"
                                @click="onSubmit"
                                :disabled="!valid"
                                large
                        >
                            SIGN UP
                        </v-btn>
                        <v-label large>
                            &nbsp; or &nbsp;
                        </v-label>
                        <v-btn
                                outlined
                                color="primary"
                                @click="onSignIn"
                                :disabled=false
                                large
                        >
                            SIGN IN
                        </v-btn>
                        <v-spacer></v-spacer>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    const emailRegex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/

    export default {
        data () {
            return {
                name: '',
                email: '',
                password: '',
                confirmPassword: '',
                valid: false,
                nameRules: [
                    v => !!v || 'Field full name is required',
                    v => (v && v.length >= 3) || 'Enter the correct information'
                ],
                emailRules: [
                    v => !!v || 'E-mail is required',
                    v => emailRegex.test(v) || 'E-mail must be valid'
                ],
                passwordRules: [
                    v => !!v || 'Password is required',
                    v => (v && v.length >= 6) || 'Password must be equal or more than 6 characters'
                ],
                confirmPasswordRules: [
                    v => !!v || 'Password is required',
                    v => v === this.password || 'Password should match'
                ]
            }
        },
        methods: {
            onSubmit () {
                if (this.$refs.form.validate()) {
                    let user = {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                    }
                    console.log(user)
                }
            },
            onSignIn () {

            },
        }
    }
</script>