<template>
    <VContainer
        fluid
        fill-height
    >
        <VLayout
            align-center
            justify-center
        >
            <VFlex
                xs12
                sm8
                md6
            >
                <VCard class="elevation-12">
                    <VToolbar
                        dark
                        color="primary"
                    >
                        <VToolbarTitle>
                            Welcome to Metrica!
                        </VToolbarTitle>
                    </VToolbar>
                    <VCardText>
                        <VForm
                            lazy-validation
                            ref="form"
                            v-model="valid"
                        >
                            <VTextField
                                prepend-icon="person"
                                label="Full name"
                                type="name"
                                name="name"
                                v-model="newUser.name"
                                :rules="nameRules"
                            />
                            <VTextField
                                prepend-icon="email"
                                label="Email"
                                type="email"
                                name="email"
                                v-model="newUser.email"
                                :rules="emailRules"
                            />
                            <VTextField
                                prepend-icon="lock"
                                label="Password"
                                name="password"
                                autocomplete="new-password"
                                v-model="newUser.password"
                                :append-icon="show1 ? 'visibility' : 'visibility_off'"
                                :counter="8"
                                :rules="passwordRules"
                                :type="show1 ? 'text' : 'password'"
                                @click:append="show1 = !show1"
                            />
                            <VTextField
                                prepend-icon="lock"
                                label="Confirm password"
                                name="confirmPassword"
                                autocomplete="new-password"
                                v-model="newUser.confirmPassword"
                                :append-icon="show2 ? 'visibility' : 'visibility_off'"
                                :counter="8"
                                :rules="confirmPasswordRules"
                                :type="show2 ? 'text' : 'password'"
                                @click:append="show2 = !show2"
                            />
                        </VForm>
                    </VCardText>
                    <VCardActions>
                        <VSpacer />
                        <VBtn
                            large
                            color="primary"
                            :disabled="!valid"
                            @click="onSignUp"
                        >
                            SIGN UP
                        </VBtn>
                        <VLabel large>
                            &nbsp; or &nbsp;
                        </VLabel>
                        <VBtn
                            outlined
                            large
                            color="primary"
                            :disabled="false"
                            @click="onSignIn"
                        >
                            SIGN IN
                        </VBtn>
                        <VSpacer />
                    </VCardActions>
                </VCard>
            </VFlex>
        </VLayout>
    </VContainer>
</template>

<script>
    import {mapActions} from 'vuex';
    import {SIGNUP} from "@/store/modules/auth/types/actions";
    import {validateEmail} from '@/services/validation';
    import {validatePassword} from '@/services/validation';
    import { SHOW_ERROR_MESSAGE } from "@/store/modules/notification/types/actions";

    export default {
        data () {
            return {
                show1: false,
                show2: false,
                newUser: {
                    name: '',
                    email: '',
                    password: '',
                    confirmPassword: '',
                },

                valid: false,
                nameRules: [
                    v => !!v || 'Field full name is required',
                    v => (v && v.length >= 5 && (v.split(" ").length - 1) >= 1) || 'Enter the correct information'
                ],
                emailRules: [
                    v => !!v || 'E-mail is required',
                    v => validateEmail(v) || 'E-mail must be valid',
                ],
                passwordRules: [
                    v => !!v || 'Password is required',
                    v => validatePassword(v) || 'Password must be equal or more than 8 characters'
                ],
                confirmPasswordRules: [
                    v => !!v || 'Password is required',
                    v => v === this.newUser.password || 'Password should match'
                ]
            }
        },
        methods: {
            ...mapActions('auth', {
                signup: SIGNUP
            }),
            ...mapActions('notification', {
                showErrorMessage: SHOW_ERROR_MESSAGE
            }),
            onSignUp () {
                if (this.$refs.form.validate()) {
                    this.signup({
                        name: this.newUser.name,
                        email: this.newUser.email,
                        password: this.newUser.password,
                    }).then(() => {
                        this.$router.push({name: 'login'});
                    }, err => {
                        this.showErrorMessage(err.message);
                    })
                }
            },

            onSignIn () {
                return this.$router.push({name: 'login'});
            },
        },
    }
</script>