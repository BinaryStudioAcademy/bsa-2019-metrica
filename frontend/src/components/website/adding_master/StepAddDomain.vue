<template>
    <VContainer>
        <VCard
            flat
            color="transparent"
            class="form-card"
        >
            <VContainer pa-1>
                <div class="subtitle-2 font-weight-bold">Add website to track info about</div>
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
                    ></VSwitch>
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
    import {SAVE_NEW_WEBSITE, SET_DOMAIN, SET_SPA} from "@/store/modules/website/types/actions";

    const domainRegex = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;

    export default {
        name: 'StepAddDomain',
        props: {
            errorMessage: String,
        },
        data() {
            return {
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
            errorText() {
                return this.errorMessage;
            }
        },
        created () {
            this.domain = this.newWebsite.domain;
            this.single_page = this.newWebsite.single_page;
        },
        methods: {
            ...mapActions('website', {
                setDomain: SET_DOMAIN,
                setSinglePage: SET_SPA,
                saveNewSite: SAVE_NEW_WEBSITE
            }),
            onGoToNextStep () {
                if (this.$refs.form.validate()) {
                    this.setDomain(this.domain).then((res) => {
                        this.setSinglePage(this.single_page).then((res) => {
                            this.saveNewSite().then((res) => {
                                this.$router.push({name: 'add_websites_step_3'});
                            })
                                .catch((res) => {
                                    this.onError(res.errors);
                                });
                        })
                    });
                }
            },
            onError (errors) {
                if (errors.name) {

                    this.$router.push({name: 'add_websites_step_1', params: {errorMessage: errors.name}});

                } else if (errors.domain) {

                    this.$router.push({name: 'add_websites_step_2', params: {errorMessage: errors.domain}});
                } else if (errors.message) {

                    this.$router.push({name: 'add_websites_step_1', params: {errorMessage: errors.message}});
                }
            },

        }
    };
</script>

<style lang="scss" scoped>
    .form-card {
        padding-top: 15px;

        .subtitle-2 {
            letter-spacing: 0.4px;
            line-height: 15px;
            color: rgba(18, 39, 55, 0.5);
        }
    }
</style>