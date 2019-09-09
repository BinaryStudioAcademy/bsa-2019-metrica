<template>
    <div class="form">
        <VSubheader
            class="body-1 grey--text text--darken-1 pa-0 mb-3 mt-6"
        >
            Reset password
        </VSubheader>
        <VForm
            lazy-validation
            ref="form"
            v-model="valid"
        >
            <div class="password-group">
                <label
                    class="caption grey--text"
                >
                    New password
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
                        min-width="140px"
                        color="primary"
                        :disabled="!valid"
                    >
                        CHANGE PASSWORD
                    </VBtn>
                    <RouterLink
                        class="signin mt-5"
                        :to="{name: 'login'}"
                    >
                        Sign in
                    </RouterLink>
                </div>
            </div>
        </VForm>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';
    import {validatePassword} from '@/services/validation';
    import { SHOW_SUCCESS_MESSAGE, SHOW_ERROR_MESSAGE } from "@/store/modules/notification/types/actions";
    import jwtService from "@/services/jwtService";

    export default {
        name: "ChangePasswordForm",
        data () {
            return {
                show1: false,
                show2: false,
                newUser: {
                    password: '',
                    confirmPassword: '',
                },
                valid: false,
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
        created() {
            if (jwtService.checkExpireToken(this.$route.query.token)) {
                this.showErrorMessage('Sorry, your token was expired. Please, enter your email again.');
                this.$router.push({name: 'reset-password'});
            }
        },
        methods: {
            ...mapActions('auth', {

            }),
            ...mapActions('notification', {
                showSuccessMessage: SHOW_SUCCESS_MESSAGE,
                showErrorMessage: SHOW_ERROR_MESSAGE
            }),
        },
    };
</script>
<style lang="scss" scoped>

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

    .form{
        width: 75%;
    }

    .signin{
        min-width: 80px;
        margin-left: 20px;
    }

</style>