<template>
    <VContainer>
        <VCard
            flat
            color="transparent"
            class="form-card"
        >
            <VContainer pa-1>
                <div class="subtitle-2 font-weight-bold">Tracking ID</div>
                <VForm lazy-validation>
                    <VCardText class="mb-2 pa-0 mt-2">
                        <VTextField
                            :value="trackingInfoId"
                            single-line
                            readonly
                            solo
                        />
                    </VCardText>
                    <VCardText class="mb-2 pa-0">
                        <div class="subtitle-2 mb-2 font-weight-bold">Website tracking</div>
                        <div class="caption mb-2">This is Global Site Tag tracking code for your website.</div>
                        <VTextarea
                            solo
                            auto-grow
                            readonly
                            rows="6"
                            value="<!--Global site tag - Analitycs-->
                            <script src='http://website.com?id=123456798-09>
                                (function (i, s, o, g, r, a, m) {
                                    i['GoogleAnalyticsObject'] = r;
                                    i[r] = i[r] || function () {
                                        (i[r].q = i[r].q || []).push(arguments)
                                    }, i[r].l = 1 * new Date();
                                    a = s.createElement(o)
                            </script>"
                        >
                        </VTextarea>
                    </VCardText>
                </VForm>
                <VBtn
                    @click="onToDashboard"
                    large
                    class="white--text mt-3"
                    color="#3C57DE"
                >
                    Get Started
                </VBtn>
            </VContainer>
        </VCard>
    </VContainer>
</template>

<script>
    export default {
        name: 'StepTrackingInfo',
        props: {
            trackingInfoId: String
        },
        methods: {
            onToDashboard (){
                this.$router.push({path: '/dashboard'});
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
