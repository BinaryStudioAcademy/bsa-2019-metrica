<template>
    <VContent>
        <VFlex
            lg6
            md6
            sm12
            xs12
            :class="{'mx-5': $vuetify.breakpoint.smAndUp}"
        >
            <VContainer>
                <VSubheader
                    class="body-1 grey--text text--darken-1 pa-0 mb-3 mt-6"
                >
                    Welcome to Metrica!
                </VSubheader>
                <VForm
                    ref="form"
                >
                    <label
                        class="caption grey--text"
                    >
                        Email
                    </label>
                    <VTextField
                        name="email"
                        class="no-underline mt-3"
                        solo
                        v-model="email"
                        type="text"
                        :rules="emailRules"
                        required
                    />
                    <label
                        class="caption grey--text"
                    >
                        Password
                    </label>
                    <VTextField
                        :append-icon="showPassword ? 'visibility' : 'visibility_off'"
                        :type="showPassword ? 'text' : 'password'"
                        @click:append="showPassword = !showPassword"
                        name="password"
                        class="no-underline my-3"
                        solo
                        v-model="password"
                        :rules="passwordRules"
                        required
                    />
                </VForm>
                <VBtn
                    @click="onLogin"
                    class="mt-5"
                    color="primary"
                >
                    Login
                </VBtn>
                <VCardActions>
                    <RouterLink
                        class="link"
                        :to="{name: 'reset-password'}"
                    >
                        Forgot Password?
                    </RouterLink>
                </VCardActions>
            </VContainer>
        </VFlex>
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
                    this.login({
                        email: this.email,
                        password: this.password
                    }).then(() => {
                        this.$emit("success");
                        this.showSuccessMessage('Logged in');
                    }).catch((error) => {
                        this.showErrorMessage(error);
                    });
                }
            }
        }
    };
</script>

<style lang="scss" scoped>
::v-deep .v-btn {
    width: 105px;
}
</style>
