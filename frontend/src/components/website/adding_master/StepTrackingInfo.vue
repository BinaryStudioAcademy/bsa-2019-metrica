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
                    Tracking ID
                </div>
                <VForm lazy-validation>
                    <VCardText class="mb-12 pa-0 mt-5">
                        <VTextField
                            single-line
                            readonly
                            solo
                            :value="currentWebsite.tracking_number"
                        />
                    </VCardText>
                    <VCardText class="mb-2 pa-0">
                        <div
                            class="subtitle-2 title-text mb-3"
                        >
                            Website tracking
                        </div>
                        <div class="caption mb-3">
                            This is Global Site tag tracking code for you website.
                            Copy and Paste this code as the
                            first item into the &lt;HEAD> of every Webpage you want to track
                        </div>
                        <TrackWebsite
                            :tracking-number="currentWebsite.tracking_number"
                            :spa="currentWebsite.single_page"
                        />
                    </VCardText>
                </VForm>
                <VBtn
                    color="#3C57DE"
                    large
                    class="white--text mt-6"
                    @click="onToDashboard"
                >
                    Get Started
                </VBtn>
            </VContainer>
        </VCard>
    </VContainer>
</template>
<script>
    import TrackWebsite from '../TrackWebsite.vue';
    import {mapGetters} from 'vuex';
    import {GET_CURRENT_WEBSITE} from "@/store/modules/website/types/getters";
    export default {
        name: 'StepTrackingInfo',
        components: {
            TrackWebsite
        },
        computed: {
            ...mapGetters('website', {
                currentWebsite: GET_CURRENT_WEBSITE
            }),
        },
        methods: {
            onToDashboard (){
                this.$router.push({path: '/dashboard'});
            }
        }
    };
</script>
<style lang="scss" scoped>
    code {
        color: black !important;
        padding: 0 10px !important;
    }
</style>
