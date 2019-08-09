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
                >
                    <VCardText class="mb-4 ps-0 mt-2 pt-0">
                        <VTextField
                            :error="!!errorText"
                            :error-messages="errorText"
                            v-model="domain"
                            :rules="domainRules"
                            required
                            label="Website domain"
                            class="form-input"
                            single-line
                            solo
                        />
                    </VCardText>
                    <VSwitch
                        v-model="single_page"
                        color="#3C57DE"
                        inset
                        label="Single page app"
                    ></VSwitch>
                </VForm>
                <VBtn
                    @click="onGoToNextStep"
                    large
                    class="white--text mt-4"
                    color="#3C57DE"
                >
                    Get Tracking Info
                </VBtn>
            </VContainer>
        </VCard>
    </VContainer>
</template>

<script>
    const domainRegex = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
    export default {
        name: 'StepAddDomain',
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
            errorText() {
                return this.$parent.currentError;
            }
        },
        methods: {
            onGoToNextStep () {
                if (this.$refs.form.validate()) {
                    this.$emit('go-to-next-step', {
                        domain: this.domain,
                        single_page: this.single_page
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

        .form-input {
            height: 48px;

            &.v-input--is-focused {
                border:1px solid rgba(60, 87, 222, 0.52) ;
            }
        }
    }
</style>