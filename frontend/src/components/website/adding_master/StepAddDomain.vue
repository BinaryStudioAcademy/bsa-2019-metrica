<template>
    <VContainer>
        <VCard
            flat
            color="transparent"
            class="form-card"
        >
            <VContainer pa-1>
                <div
                    class="subtitle-2 title-text font-weight-bold"
                >
                    Add website to track info about
                </div>
                <VForm
                    ref="form"
                    lazy-validation
                    @submit.prevent="onGoToNextStep"
                >
                    <VCardText class="mb-4 ps-0 mt-2 pt-0">
                        <VTextField
                            v-model="domain"
                            label="Website domain"
                            class="form-input"
                            required
                            single-line
                            solo
                            :error="!!errorText"
                            :error-messages="errorText"
                            :rules="domainRules"
                        />
                    </VCardText>
                    <VSwitch
                        v-model="single_page"
                        label="Single page app"
                        color="#3C57DE"
                        inset
                    />
                </VForm>
                <VBtn
                    large
                    class="white--text mt-4"
                    color="#3C57DE"
                    @click="onGoToNextStep"
                >
                    Get Tracking Info
                </VBtn>
            </VContainer>
        </VCard>
    </VContainer>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
    import {GET_NEW_WEBSITE} from "@/store/modules/website/types/getters";
    import {SAVE_NEW_WEBSITE, SET_WEBSITE_DATA} from "@/store/modules/website/types/actions";

    const domainRegex = /(https?:\/\/)?(www\.)?[-a-zA-Z0-9@:%._~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_.~#()?&//=]*)/;

    export default {
        name: 'StepAddDomain',
        data() {
            return {
                errorMessage: '',
                domain: '',
                valid: false,
                single_page: false,
                domainRules: [
                    v => !!v || 'Website domain is required',
                    v => domainRegex.test(v) || 'Domain must be correct'
                ],
            }
        },
        computed: {
            ...mapGetters('website', {
                newWebsite: GET_NEW_WEBSITE
            }),
            errorText (){
                return this.errorMessage;
            }
        },
        created () {
            this.domain = this.newWebsite.domain;
            this.single_page = this.newWebsite.single_page;
        },
        methods: {
            ...mapActions('website', {
                setWebsiteData: SET_WEBSITE_DATA,
                saveNewSite: SAVE_NEW_WEBSITE
            }),
            onGoToNextStep () {
                if (this.$refs.form.validate()) {
                    this.setWebsiteData({
                        domain: this.domain,
                        single_page: this.single_page
                    }).then(() => this.saveNewSite()
                        .then(() => this.$router.push({name: 'add_websites_step_3'}))
                        .catch((res) => this.onError(res.errors))
                    );
                }
            },
            onError (errors) {
                if (errors.name) {

                    this.$router.push({name: 'add_websites_step_1', params: {errorMessage: errors.name}});
                    return;
                }

                if (errors.domain) {

                    this.errorMessage = errors.domain;
                    return;
                }

                if (errors.message) {

                    this.$router.push({name: 'add_websites_step_1', params: {errorMessage: errors.message}});
                    return;
                }
            },

        }
    };
</script>
