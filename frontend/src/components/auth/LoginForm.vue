<template>
    <div class="form">
        <Spinner
            v-if="isLoading"
        />
        <h3>Welcome to Metrica!</h3>
        <VForm
            lazy-validation
            ref="form"
            v-model="valid"
        >
            <VTextField
                outlined
                label="Email"
                type="email"
                name="email"
                v-model="email"
                :rules="emailRules"
                required
            />

            <VTextField
                class="password"
                outlined
                label="Password"
                name="password"
                autocomplete="new-password"
                v-model="password"
                :append-icon="showPassword ? 'visibility' : 'visibility_off'"
                :counter="8"
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
                        color="#3C57DE"
                        :disabled="!valid"
                        @click="onLogin"
                    >
                        SIGN IN
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
</template>

<script>
    import {mapActions} from 'vuex';
    import {LOGIN} from "@/store/modules/auth/types/actions";
    import { SHOW_SUCCESS_MESSAGE, SHOW_ERROR_MESSAGE } from "@/store/modules/notification/types/actions";
    import {validateEmail} from '@/services/validation';
    import {validatePassword} from '@/services/validation';
    import Spinner from "../utilites/Spinner";

    export default {
        components: {
            Spinner
        },

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
                        this.isLoading = false;
                        this.$emit("success");
                        this.showSuccessMessage('Logged in');
                    }).catch((error) => {
                        this.isLoading = false;
                        this.showErrorMessage(error);
                    });
                }
            }
        }
    };
</script>

<style lang="scss" scoped>

    .form {
        width: 50%;
        font-family: Gilroy;

        .login-btn {
            color: white;
        }

        .v-btn {
            font-family: Gilroy;
            letter-spacing: 0.4px;
            text-transform: none;
            border-radius: 3px;

            +.start {
                background: #FFFFFF;
                border: 2px solid #3C57DE;
                box-sizing: border-box;
                border-radius: 3px;
                color: #3C57DE;
            }
        }

        h3 {
            margin-bottom: 30px;
            font-size: 19px;
            line-height: 19px;
        }

        .password {
            line-height: 20px;
        }

        .v-input__slot {
            min-height: 45px;
        }

        .password-group {
            display: flex;
            flex-direction: column;
        }

        .btn-group {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }

        .choice {
            align-self: center;
            margin: 0 15px;
        }

        .forgot-password-link {
            color: #3C57DE;
        }
    }
</style>
