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
                                    v-model="name"
                                    name="name"
                                    :rules="nameRules"
                            />
                            <VTextField
                                    prepend-icon="email"
                                    label="Email"
                                    type="email"
                                    v-model="email"
                                    name="email"
                                    :rules="emailRules"
                            />
                            <VTextField
                                    prepend-icon="lock"
                                    label="Password"
                                    type="password"
                                    v-model="password"
                                    name="password"
                                    :counter="6"
                                    :rules="passwordRules"
                            />
                            <VTextField
                                    prepend-icon="lock"
                                    label="Confirm password"
                                    type="password"
                                    v-model="confirmPassword"
                                    name="confirmPassword"
                                    :counter="6"
                                    :rules="confirmPasswordRules"
                            />
                        </VForm>
                    </VCardText>
                    <VCardActions>
                        <VSpacer/>
                        <VBtn
                                large
                                color="primary"
                                @click="onSubmit"
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
                                :disabled=false
                        >
                            SIGN IN
                        </VBtn>
                        <VSpacer/>
                    </VCardActions>
                </VCard>
            </VFlex>
        </VLayout>
    </VContainer>
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