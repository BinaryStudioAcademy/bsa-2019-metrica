<template>
    <ContentLayout>
        <VFlex
            lg6
            md6
            sm12
            xs12
        >
            <VForm
                ref="form"
            >
                <div class="inline-element mb-4">
                    <label>Invite User</label>
                    <VTextField
                        name="invite_user"
                        v-model="invitedUserEmail"
                        :success-messages="showSuccessMessage"
                        :error-messages="showErrorMessage"
                        placeholder="user email"
                        single-line
                        solo
                        :rules="emailRules"
                        required
                    />
                    <VCardActions class="px-0 mt-8 mb-12 ml-6">
                        <VBtn
                            @click="invite"
                            color="primary"
                            width="100"
                        >
                            Invite
                        </VBtn>
                    </VCardActions>
                </div>
                <p
                    v-for="member in currentTeam"
                    :key="member.name"
                    class="inline-element"
                >
                    <span>{{ member.name }} </span>
                    <span>{{ member.email }}</span>
                </p>
            </VForm>
        </VFlex>
    </ContentLayout>
</template>

<script>
    import ContentLayout from '../layout/ContentLayout.vue';
    import { mapGetters, mapActions } from 'vuex';
    import {GET_CURRENT_TEAM} from "../../store/modules/team/types/getters";
    import {INVITE_USER, FETCH_TEAM_MEMBERS} from "../../store/modules/team/types/actions";
    import {validateEmail} from '@/services/validation';

    export default {
        name: 'InviteMemberForm',
        components: {ContentLayout},
        data () {
            return {
                invitedUserEmail: '',
                showErrorMessage: '',
                showSuccessMessage: '',
                emailRules: [
                    v => validateEmail(v) || 'E-mail must be valid',
                ],
            };
        },
        computed: {
            ...mapGetters('team', {
                currentTeam: GET_CURRENT_TEAM
            }),
        },
        created() {
            this.fetchTeam();
        },
        methods: {
            ...mapActions('team', {
                inviting: INVITE_USER,
                fetchTeam: FETCH_TEAM_MEMBERS,
            }),
            invite() {
                if(this.$refs.form.validate()) {
                    this.inviting(this.invitedUserEmail)
                        .then(() => {
                            this.showSuccessMessage = 'Member is invited.';
                        }).catch((err) => {
                            this.showErrorMessage = err;
                        });
                }
            }
        },
    };
</script>

<style lang="scss" scoped>
    .inline-element {
        display: grid;
        grid-template-columns: 20% 65% 15%;
        align-items: baseline;
        @media (max-width: 767px) {
            & {
                grid-template-columns: 100%;
            }
        }
    }
</style>