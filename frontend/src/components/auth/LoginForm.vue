<template>
    <VContent>
        <VContainer
            fluid
            fill-height
        >
            <VLayout
                content
                wrap
                align-start
                justify-center
            >
                <VFlex
                    form-wrapper
                    xs12
                    sm8
                    md6
                >
                    <VLayout
                        column
                        align-items-center
                    >
                        <div class="form">
                            <VSubheader
                                class="body-1 grey--text text--darken-1 pa-0 mb-3 mt-6"
                            >
                                Welcome to Metrica!
                            </VSubheader>
                            <VForm
                                lazy-validation
                                ref="form"
                                v-model="valid"
                            >
                                <label
                                    class="caption grey--text"
                                >
                                    Email
                                </label>
                                <VTextField
                                    class="no-underline"
                                    solo
                                    type="email"
                                    name="email"
                                    v-model="email"
                                    :rules="emailRules"
                                    required
                                />
                                <label
                                    class="caption grey--text"
                                >
                                    Password
                                </label>
                                <VTextField
                                    class="no-underline password"
                                    solo
                                    name="password"
                                    autocomplete="new-password"
                                    v-model="password"
                                    :append-icon="showPassword ? 'visibility' : 'visibility_off'"
                                    :rules="passwordRules"
                                    :type="showPassword ? 'text' : 'password'"
                                    @click:append="showPassword = !showPassword"
                                    required
                                />

                                <div class="password-group">
                                    <div class="btn-group">
                                        <VBtn
                                            class="login-btn"
                                            min-width="100px"
                                            color="primary"
                                            :disabled="!valid"
                                            @click="onLogin"
                                        >
                                            {{ signInText }}
                                        </VBtn>

                                        <VBtn
                                            class="start"
                                            min-width="100px"
                                            :to="{name: 'signup'}"
                                            outlined
                                            :disabled="false"
                                        >
                                            SIGN UP
                                        </VBtn>
                                    </div>
                                    <div class="btn-group">
                                        <RouterLink
                                            class="forgot-password-link"
                                            :to="{name: 'reset-password'}"
                                        >
                                            Forgot password?
                                        </RouterLink>
                                    </div>
                                </div>
                            </VForm>
                        </div>
                    </VLayout>
                </VFlex>
                <VFlex
                    image
                    sm12
                    md6
                >
                    <VImg
                        src="/assets/images/home.png"
                        alt="Man"
                    />
                </VFlex>
            </VLayout>
        </VContainer>
    </VContent>
</template>

<script>
    import {mapActions} from 'vuex';
    import {LOGIN} from "@/store/modules/auth/types/actions";
    import { SHOW_SUCCESS_MESSAGE, SHOW_ERROR_MESSAGE } from "@/store/modules/notification/types/actions";
    import {validateEmail} from '@/services/validation';
    import {validatePassword} from '@/services/validation';

    export default {
        data() {
            return {
                email: '',
                password: '',
                showPassword: false,
                valid: false,
                isLoading: false,
                emailRules: [
                    v => !!v || 'E-mail is required',
                    v => validateEmail(v) || 'E-mail must be valid',
                ],
                passwordRules: [
                    v => !!v || 'Password is required',
                    v => validatePassword(v) || 'Password must be equal or more than 8 characters'
                ]
            };
        },
        methods: {
            ...mapActions('auth', {
                login: LOGIN
            }),
            ...mapActions('notification', {
                showSuccessMessage: SHOW_SUCCESS_MESSAGE,
                showErrorMessage: SHOW_ERROR_MESSAGE
            }),
            onLogin() {
                if (this.$refs.form.validate()) {
                    this.isLoading = true;
                    this.login({
                        email: this.email,
                        password: this.password
                    }).then(() => {
                        this.$emit("success");
                        this.showSuccessMessage('Logged in');
                    }).catch((error) => {
                        this.showErrorMessage(error);
                    }).finally(() => {
                        this.isLoading = false;
                    });
                }
            }
        },
        computed: {
            signInText() {
                return this.isLoading?'Processing...':'SIGN IN';
            }
        }
    };
</script>

<style lang="scss" scoped>
    main{
        background: #FFFFFF;
    }

    .form {
        width: 50%;

        .v-btn {
            text-transform: none;

            +.start {
                background: #FFFFFF;
                color: #3C57DE;
                margin-left: 50px;
            }
        }

        h3 {
            margin-bottom: 30px;
            font-size: 19px;
        }
        .password-group {
            display: flex;
            flex-direction: column;
        }

        .btn-group {
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-start;
        }
    }

    .image{
        padding-top: 70px;
    }

    .container{
        padding: 0px

    }

    .form-wrapper{
        padding-top: 40px;
        height: 100%;
        background: #f5f8fd;
    }
</style>
