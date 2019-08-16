<template>
    <div class="form">
        <h3>Welcome to Metrica!</h3>
        <VForm
            lazy-validation
            ref="form"
            v-model="valid"
        >
            <VTextField
                outlined
                label="Full name"
                type="name"
                name="name"
                v-model="newUser.name"
                :rules="nameRules"
            />
            <VTextField
                outlined
                label="Email"
                type="email"
                name="email"
                v-model="newUser.email"
                :rules="emailRules"
            />
            <div class="password-group">
                <VTextField
                    class="password"
                    outlined
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
                    class="password"
                    width="70%"
                    outlined
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
                <div class="btn-group">
                    <VBtn
                        class="start"
                        min-width="100px"
                        color="primary"
                        :disabled="!valid"
                        @click="onSignUp"
                    >
                        SIGN UP
                    </VBtn>
                    <div class="choice">
                        or
                    </div>
                    <VBtn
                        class="login"
                        min-width="100px"
                        :to="{name: 'login'}"
                        outlined
                        :disabled="false"
                    >
                        SIGN IN
                    </VBtn>
                </div>
            </div>
        </VForm>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';
    import {SIGN_UP} from "@/store/modules/auth/types/actions";
    import {validateEmail} from '@/services/validation';
    import {validatePassword} from '@/services/validation';
    import { SHOW_SUCCESS_MESSAGE, SHOW_ERROR_MESSAGE } from "@/store/modules/notification/types/actions";

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

h3 {
    font-family: Gilroy;
    margin-bottom: 30px;
    font-size: 19px;
    line-height: 19px;
}

.password {
    line-height: 20px;
}

.v-input__slot{
    min-height: 45px;
}

.password-group {
    display: flex;
    flex-direction: column;
    max-width: 80%;
}

.btn-group{
    display: flex;
    justify-content: space-between;
    max-width: 80%;
}

.choice{
    align-self: center;
    margin: 0 15px;
}

.form{
    width: 50%;
}

</style>