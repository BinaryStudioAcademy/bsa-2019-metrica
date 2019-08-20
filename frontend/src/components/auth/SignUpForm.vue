<template>
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
                Full name
            </label>
            <VTextField
                class="no-underline mt-1"
                solo
                type="text"
                name="name"
                v-model="newUser.name"
                :rules="nameRules"
            />
            <label
                class="caption grey--text"
            >
                Email
            </label>
            <VTextField
                class="no-underline mt-1"
                solo
                type="email"
                name="email"
                v-model="newUser.email"
                :rules="emailRules"
            />
            <div class="password-group">
                <label
                    class="caption grey--text"
                >
                    Password
                </label>
                <VTextField
                    class="no-underline my-1"
                    solo
                    name="password"
                    autocomplete="new-password"
                    v-model="newUser.password"
                    :append-icon="show1 ? 'visibility' : 'visibility_off'"
                    :rules="passwordRules"
                    :type="show1 ? 'text' : 'password'"
                    @click:append="show1 = !show1"
                />
                <label
                    class="caption grey--text"
                >
                    Confirm password
                </label>
                <VTextField
                    class="no-underline my-1"
                    solo
                    name="confirmPassword"
                    autocomplete="new-password"
                    v-model="newUser.confirmPassword"
                    :append-icon="show2 ? 'visibility' : 'visibility_off'"
                    :rules="confirmPasswordRules"
                    :type="show2 ? 'text' : 'password'"
                    @click:append="show2 = !show2"
                />
                <div class="btn-group">
                    <VBtn
                        class="mt-5"
                        min-width="100px"
                        color="primary"
                        :disabled="!valid"
                        @click="onSignUp"
                    >
                        SIGN UP
                    </VBtn>
                    <div class="choice mt-5">
                        or
                    </div>
                    <VBtn
                        class="mt-5"
                        outlined
                        color="primary"
                        min-width="100px"
                        :to="{name: 'login'}"
                        :disabled="false"
                    >
                        SIGN IN
                    </VBtn>
                </div>
            </div>
        </VForm>

        <SocialAuth />
    </div>
</template>

<script>
    import {mapActions} from 'vuex';
    import {SIGN_UP} from "@/store/modules/auth/types/actions";
    import {validateEmail} from '@/services/validation';
    import {validatePassword} from '@/services/validation';
    import { SHOW_SUCCESS_MESSAGE, SHOW_ERROR_MESSAGE } from "@/store/modules/notification/types/actions";
    import SocialAuth from "./SocialAuth";

    export default {
        components: {
            SocialAuth
        },
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
            };
        },
        methods: {
            ...mapActions('auth', {
                signUp: SIGN_UP
            }),
            ...mapActions('notification', {
                showSuccessMessage: SHOW_SUCCESS_MESSAGE,
                showErrorMessage: SHOW_ERROR_MESSAGE
            }),
            onSignUp () {
                if (this.$refs.form.validate()) {
                    this.signUp({
                        name: this.newUser.name,
                        email: this.newUser.email,
                        password: this.newUser.password,
                    }).then(() => {
                        this.$emit("success");
                        this.showSuccessMessage('You have been successfully registered! Please log in!');
                        this.$router.push({name: 'login'});
                    }).catch((error) => {
                        this.showErrorMessage(error);
                    });
                }
            },
            onSignIn () {
                return this.$router.push({name: 'login'});
            },
        },
    };
</script>

<style lang="scss" scoped>

.v-btn {
    font-family: Gilroy;
    letter-spacing: 0.4px;
    text-transform: none;
    border-radius: 3px;

    +.start {
        background: #3C57DE;
    }
    +.login {
        background: #FFFFFF;
        border: 2px solid #3C57DE;
        box-sizing: border-box;
        border-radius: 3px;
        color: #3C57DE;
    }
}

.password-group {
    display: flex;
    flex-direction: column;
    max-width: 80%;
}

.btn-group{
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 80%;
    margin-bottom: 20px;
}

.choice{
    margin: 0 15px;
}

.form{
    width: 50%;
}

</style>