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
                    Tracking ID
                </div>
                <VForm lazy-validation>
                    <VCardText class="mb-2 pa-0 mt-2">
                        <VTextField
                            single-line
                            readonly
                            solo
                            :value="currentWebsite.tracking_number"
                        />
                    </VCardText>
                    <VCardText class="mb-2 pa-0">
                        <div
                            class="subtitle-2 title-text mb-2 font-weight-bold"
                        >
                            Website tracking
                        </div>
                        <div class="caption mb-2">
                            This is Global Site Tag tracking code for your website.
                        </div>
                        <VTextarea
                            solo
                            auto-grow
                            readonly
                            rows="6"
                            :value="messageText"
                        />
                    </VCardText>
                </VForm>
                <VBtn
                    color="#3C57DE"
                    large
                    class="white--text mt-3"
                    @click="onToDashboard"
                >
                    Get Started
                </VBtn>
            </VContainer>
        </VCard>
    </VContainer>
</template>

<script>
    import {mapGetters} from 'vuex';
    import {GET_CURRENT_WEBSITE} from "@/store/modules/website/types/getters";

    export default {
        name: 'StepTrackingInfo',
        data () {
            return {
                directionText: "Here will be directions with TRACKING_INFO_ID "
            }
        },
        computed: {
            ...mapGetters('website', {
                currentWebsite: GET_CURRENT_WEBSITE
            }),
            messageText() {
                return this.directionText.replace('TRACKING_INFO_ID', this.currentWebsite.tracking_number)
            }
        },
        methods: {
            onToDashboard (){
                this.$router.push({path: '/dashboard'});
            }
        }
    };
</script>

