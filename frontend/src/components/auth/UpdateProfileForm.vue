<template>
    <v-content>
        <v-flex
                lg6
                md6
                sm12
                xs12
        >
            <v-container>
                <v-card-text
                        class="edit-container">
                    <v-subheader
                            class="edit-form-header"
                    >Profile
                    </v-subheader>
                    <v-form
                            ref="form"
                    >
                        <v-subheader
                                class="edit-form-label"
                        >Full Name
                        </v-subheader>
                        <v-text-field
                                name="name"
                                class="edit-form-input"
                                v-model="editUser.name"
                                solo
                                type="text"
                                :rules="nameRules"
                                required
                        />

                        <v-subheader
                                class="edit-form-label"
                        >Email
                        </v-subheader>
                        <v-text-field
                                name="email"
                                class="edit-form-input"
                                v-model="editUser.email"
                                solo
                                type="email"
                                :rules="emailRules"
                                required
                        />

                        <v-subheader
                                class="edit-form-label"
                        >Password
                        </v-subheader>
                        <v-text-field
                                name="input-10-1"
                                class="edit-form-input"
                                v-model="editUser.password"
                                :append-icon="showPassword ? 'visibility' : 'visibility_off'"
                                solo
                                type="showPassword ? 'text' : 'password'"
                                hint="At least 6 characters"
                                counter
                                :rules="passwordRules"
                                required
                                @click:append="showPassword = !showPassword"
                        />

                        <v-subheader
                                class="edit-form-label"
                        >Repeat password
                        </v-subheader>
                        <v-text-field
                                name="input-10-1"
                                class="edit-form-input"
                                v-model="confirmPassword"
                                :append-icon="showConfirmPassword ? 'visibility' : 'visibility_off'"
                                solo
                                type="showConfirmPassword ? 'text' : 'password'"
                                hint="At least 6 characters"
                                counter
                                :rules="confirmPasswordRules"
                                required
                                @click:append="showConfirmPassword = !showConfirmPassword"
                        />
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-btn @click="onSave" class="editUser-form-button mt-3" color="#3C57DE">Save</v-btn>
                </v-card-actions>
            </v-container>
        </v-flex>
    </v-content>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';
    import {UPDATE} from "../../store/modules/auth/types/actions";
    import {GET_AUTHENTICATED_USER} from "../../store/modules/auth/types/getters";
    import { EMPTY_USER } from '../../services/Normalizer';

    export default {
        data() {
            return {
                editUser: {
                    ...EMPTY_USER()
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
                    v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
                ],
                passwordRules: [
                    v => !!v || 'Password is required',
                    v => (v && v.length >= 6) || 'Password must be equal or more than 6 characters'
                ],
                confirmPasswordRules: [
                    v => !!v || 'Password is required',
                    v => v === this.editUser.password || 'Password should match'
                ]
            }
        },
        created() {
            this.editUser = {
                ...this.getUser
            };
        },
        computed: {
            ...mapGetters('auth', {
                getUser: 'GET_AUTHENTICATED_USER'
            }),
        },
        methods: {
            ...mapActions('auth', {
                update: 'UPDATE'
            }),

            onSave() {
                if (this.$refs.form.validate()) {
                    this.update(this.editUser)
                        .then(response => {
                            alert("Successfully updated.");
                        }, err => {
                            alert(err.message);
                        })
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .edit-form-input > > > .v-input__control {
        min-height: 1px;
    }

    .edit-form-input.v-input--is-focused {
        border: 1px solid rgba(60, 87, 222, 0.52);
        box-shadow: 0 0 14px rgba(194, 205, 223, 0.6);
    }

    .edit-form-input {
        background: #FFFFFF;
        border: 1px solid rgba(18, 39, 55, 0.11);
        box-sizing: border-box;
        border-radius: 3px;
    }

    .edit-form-input > > > input {
        min-height: 35px;
    }

    .edit-form-input > > > .v-input__prepend-outer {
        margin-top: 4px;
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
    }

    .edit-form-button > > > span {
        font-size: 14px;
        line-height: 17px;
        display: flex;
        align-items: center;
        text-align: center;
        letter-spacing: 0.4px;
    }
</style>