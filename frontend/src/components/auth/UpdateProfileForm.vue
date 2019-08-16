<template>
    <VFlex
        lg6
        md6
        sm12
        xs12
        class="ml-12 mt-11"
    >
        <VContainer>
            <VSubheader class="body-1 grey--text text--darken-1 pa-0">
                Profile
            </VSubheader>
            <VForm ref="form">
                <label class="caption grey--text mt-2 mb-3">
                    Full Name
                </label>
                <VTextField
                    name="name"
                    class="no-underline"
                    v-model="editUser.name"
                    type="text"
                    :rules="nameRules"
                    required
                    solo
                />
                <label class="caption grey--text mt-2 mb-3">
                    Email
                </label>
                <VTextField
                    name="email"
                    class="no-underline"
                    v-model="editUser.email"
                    type="email"
                    :rules="emailRules"
                    required
                    solo
                />
                <label class="caption grey--text mt-2 mb-3">
                    Password
                </label>
                <VTextField
                    name="input-10-1"
                    class="no-underline"
                    v-model="editUser.password"
                    :append-icon="passwordVisibility"
                    :type="passwordType"
                    counter
                    :rules="passwordRules"
                    required
                    solo
                    @click:append="showPassword = !showPassword"
                />
                <label class="caption grey--text mt-2 mb-3">
                    Repeat password
                </label>
                <VTextField
                    name="input-10-1"
                    class="no-underline"
                    v-model="confirmPassword"
                    :append-icon="confirmPasswordVisibility"
                    :type="confirmPasswordType"
                    counter
                    :rules="confirmPasswordRules"
                    required
                    solo
                    @click:append="showConfirmPassword = !showConfirmPassword"
                />
            </VForm>
            <VBtn
                @click="onSave"
                class="mt-9"
                color="primary"
            >
                Save
            </VBtn>
        </VContainer>
    </VFlex>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import {UPDATE_USER} from '@/store/modules/auth/types/actions';
    import {GET_AUTHENTICATED_USER} from '@/store/modules/auth/types/getters';
    import {validateEmail} from '@/services/validation';
    import {validatePassword} from '@/services/validation';

    export default {
        data() {
            return {
                editUser: {
                    name: '',
                    email: '',
                    password: '',
                },
                confirmPassword: '',
                valid: false,
                showPassword: false,
                showConfirmPassword: false,
                nameRules: [
                    v => !!v || 'Field full name is required',
                    v => (v && v.length >= 3) || 'Enter the correct information'
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
                    v => v === this.editUser.password || 'Password should match'
                ]
            };
        },

        created() {
            this.editUser = {
                ...this.editUser,
                ...this.user,
            };
        },

        computed: {
            ...mapGetters('auth', {
                user: GET_AUTHENTICATED_USER
            }),
            passwordVisibility: function() {
                return this.showPassword ? 'visibility' : 'visibility_off';
            },
            confirmPasswordVisibility: function () {
                return this.showConfirmPassword ? 'visibility' : 'visibility_off';
            },
            passwordType: function () {
                return this.showPassword ? 'text' : 'password';
            },
            confirmPasswordType: function () {
                return this.showConfirmPassword ? 'text' : 'password';
            }
        },

        methods: {
            ...mapActions('auth', {
                update: UPDATE_USER
            }),

            onSave() {
                if (this.$refs.form.validate()) {
                    this.update(this.editUser)
                        .catch((error) => {
                            alert(error.message);
                        });
                }
            },
        }
    };
</script>

<style lang="scss" scoped>
::v-deep .v-input__append-inner {
    align-self: center;
    margin-right: 4px;
    margin-top: 0;
}

::v-deep .v-btn {
    width: 105px;
}
</style>