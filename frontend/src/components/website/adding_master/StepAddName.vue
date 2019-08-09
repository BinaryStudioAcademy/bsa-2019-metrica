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
                >
                    <VCardText class="mb-4 pa-0 mt-2">
                        <VTextField
                            :error="!!errorText"
                            :error-messages="errorText"
                            v-model="name"
                            :rules="nameRules"
                            required
                            label="Website name"
                            class="form-input"
                            single-line
                            solo
                        />
                    </VCardText>
                </VForm>
                <VBtn
                    @click="onGoToNextStep"
                    large
                    class="white--text mt-6"
                    color="#3C57DE"
                >
                    Add Website
                </VBtn>
            </VContainer>
        </VCard>
    </VContainer>
</template>

<script>
    export default {
        name: 'StepAddName',
        props: {
            error: String,
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
            errorText() {
                return this.$parent.currentError;
            }
        },
        methods: {
            onGoToNextStep () {
                if (this.$refs.form.validate()) {
                    this.$emit('go-to-next-step', {
                        name: this.name
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
