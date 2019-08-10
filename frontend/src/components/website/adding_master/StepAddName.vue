<template>
    <VContainer>
        <VCard
            flat
            color="transparent"
            class="form-card"
        >
            <VContainer pa-1>
                <div class="subtitle-2 font-weight-bold">Website name</div>
                <VForm
                    ref="form"
                    lazy-validation
                    @submit.prevent="onGoToNextStep"
                >
                    <VCardText class="mb-4 pa-0 mt-2">
                        <VTextField
                            v-model="name"
                            label="Website name"
                            class="form-input"
                            single-line
                            solo
                            required
                            :rules="nameRules"
                            :error="!!errorText"
                            :error-messages="errorText"
                        />
                    </VCardText>
                </VForm>
                <VBtn
                    large
                    color="#3C57DE"
                    class="white--text mt-6"
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
    import {SET_NAME} from "@/store/modules/website/types/actions";

    export default {
        name: 'StepAddName',
        props: {
            errorMessage: String,
        },
        data() {
            return {
                name: '',
                valid: false,
                nameRules: [
                    v => !!v || 'Website name is required',
                    v => (v && v.length >= 8) || 'Website name must be correct. Name must be at least 8 characters.'
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
            this.name = this.newWebsite.name;
        },
        methods: {
            ...mapActions('website', {
                setName: SET_NAME,
            }),
            onGoToNextStep () {
                if (this.$refs.form.validate()) {
                    this.setName(this.name).then((res) => {
                        this.$router.push({name: 'add_websites_step_2'});
                    });
                }
            }
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
