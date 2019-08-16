<template>
    <VContainer>
        <VCard
            flat
            color="transparent"
            class="form-card"
        >
            <VContainer pa-1>
                <div
                    class="subtitle-2 title-text"
                >
                    Website name
                </div>
                <VForm
                    ref="form"
                    lazy-validation
                    @submit.prevent="onGoToNextStep"
                >
                    <VCardText class="mb-4 pa-0 mt-2">
                        <VTextField
                            v-model="name"
                            label="Website name"
                            class="form-input no-underline mt-5"
                            single-line
                            solo
                            required
                            :rules="nameRules"
                            :error="!!errorMessage"
                            :error-messages="errorMessage"
                        />
                    </VCardText>
                </VForm>
                <VBtn
                    large
                    color="#3C57DE"
                    class="white--text mt-12"
                    @click="onGoToNextStep"
                >
                    Add Website
                </VBtn>
            </VContainer>
        </VCard>
    </VContainer>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import {GET_NEW_WEBSITE} from "@/store/modules/website/types/getters";
    import {SET_WEBSITE_DATA} from "@/store/modules/website/types/actions";

    export default {
        name: 'StepAddName',
        props: {
            errorMessage: {
                type: String,
                default: ''
            }
        },
        data() {
            return {
                name: '',
                valid: false,
                nameRules: [
                    v => !!v || 'Website name is required',
                    v => (v && v.length >= 8) || 'Website name must be correct. Name must be at least 8 characters.'
                ],
            };
        },
        computed: {
            ...mapGetters('website', {
                newWebsite: GET_NEW_WEBSITE
            }),
        },
        created () {
            this.name = this.newWebsite.name;
        },
        methods: {
            ...mapActions('website', {
                setWebsiteData: SET_WEBSITE_DATA,
            }),
            onGoToNextStep () {
                if (this.$refs.form.validate()) {
                    this.setWebsiteData({name: this.name}).then(() => {
                        this.$router.push({name: 'add_websites_step_2'});
                    });
                }
            }
        }
    };
</script>

