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
                                v-model="newUser.name"
                                name="name"
                                :rules="nameRules"
                            />
                            <VTextField
                                prepend-icon="email"
                                label="Email"
                                type="email"
                                v-model="newUser.email"
                                name="email"
                                :rules="emailRules"
                            />
                            <VTextField
                                prepend-icon="lock"
                                label="Password"
                                type="password"
                                v-model="newUser.password"
                                name="password"
                                :counter="8"
                                :rules="passwordRules"
                            />
                            <VTextField
                                prepend-icon="lock"
                                label="Confirm password"
                                type="password"
                                v-model="newUser.confirmPassword"
                                name="confirmPassword"
                                :counter="8"
                                :rules="confirmPasswordRules"
                            />
                        </VForm>
                    </VCardText>
                    <VCardActions>
                        <VSpacer />
                        <VBtn
                            large
                            color="primary"
                            @click="onSignUp"
                            :disabled="!valid"
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
                            @click="onSignIn"
                            :disabled="false"
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

    const emailRegex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;

    export default {
        data () {
            return {
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
                    v => emailRegex.test(v) || 'E-mail must be valid'
                ],
                passwordRules: [
                    v => !!v || 'Password is required',
                    v => (v && v.length >= 8) || 'Password must be equal or more than 6 characters'
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
            onSignUp () {
                if (this.$refs.form.validate()) {
                    this.signup({
                        name: this.newUser.name,
                        email: this.newUser.email,
                        password: this.newUser.password,
                    }).then(function (res) {
                        if (res.error) {
                            this.onError(res.error.message);
                        } else {
                            this.onSuccess('Success!');
                            this.$router.push({name: 'login'});
                        }
                    }).catch(function (err) {
                        alert(err.message);
                    });
                }
            },

            onSignIn () {
                return this.$router.push({path: '/login'});
            },

            onError (error) {
                alert(error.message);
            },

            onSuccess (success) {
                alert(success.message);
            },
        },


    }
</script>