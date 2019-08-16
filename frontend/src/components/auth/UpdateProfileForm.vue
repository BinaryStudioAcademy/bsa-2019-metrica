<template>
    <VContent>
        <VFlex
            lg6
            md6
            sm12
            xs12
        >
            <VContainer>
                <VCardText class="edit-container">
                    <VSubheader class="edit-form-header">
                        Profile
                    </VSubheader>
                    <VForm ref="form">
                        <VSubheader class="edit-form-label">
                            Full Name
                        </VSubheader>
                        <VTextField
                            name="name"
                            class="edit-form-input"
                            v-model="editUser.name"
                            solo
                            type="text"
                            :rules="nameRules"
                            required
                        />
                        <VSubheader class="edit-form-label">
                            Email
                        </VSubheader>
                        <VTextField
                            name="email"
                            class="edit-form-input"
                            v-model="editUser.email"
                            solo
                            type="email"
                            :rules="emailRules"
                            required
                        />
                        <VSubheader class="edit-form-label">
                            Password
                        </VSubheader>
                        <VTextField
                            name="input-10-1"
                            class="edit-form-input"
                            v-model="editUser.password"
                            :append-icon="passwordVisibility"
                            solo
                            :type="passwordType"
                            counter
                            :rules="passwordRules"
                            required
                            @click:append="showPassword = !showPassword"
                        />
                        <VSubheader class="edit-form-label">
                            Repeat password
                        </VSubheader>
                        <VTextField
                            name="input-10-1"
                            class="edit-form-input"
                            v-model="confirmPassword"
                            :append-icon="confirmPasswordVisibility"
                            solo
                            :type="confirmPasswordType"
                            counter
                            :rules="confirmPasswordRules"
                            required
                            @click:append="showConfirmPassword = !showConfirmPassword"
                        />
                    </VForm>
                </VCardText>
                <VCardActions>
                    <VBtn
                        @click="onSave"
                        class="editUser-form-button mt-3"
                        color="#3C57DE"
                    >
                        Save
                    </VBtn>
                </VCardActions>
            </VContainer>
        </VFlex>
    </VContent>
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
.edit-form-input {
    background: #FFFFFF;
    box-sizing: border-box;
    border-radius: 3px;
}

.edit-form-label {
    font-size: 12px;
    line-height: 15px;
    display: flex;
    align-items: center;
    letter-spacing: 0.4px;

    color: rgba(18, 39, 55, 0.5);
}

.edit-form-header {
    font-size: 16px;
    line-height: 19px;
    display: flex;
    align-items: center;
    letter-spacing: 0.4px;

    color: #122737;
}

.edit-container {
    padding: 8px;
}

.edit-form-button {
    border-radius: 3px;

    ::v-deep {
        span {
            font-size: 14px;
            line-height: 17px;
            display: flex;
            align-items: center;
            text-align: center;
            letter-spacing: 0.4px;
        }
    }
}
</style>