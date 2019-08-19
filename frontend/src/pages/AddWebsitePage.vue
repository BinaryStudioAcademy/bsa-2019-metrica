<template>
    <VContainer
        fluid
        pa-0
        class="left-container"
    >
        <div class="content-with-padding">
            <VFlex
                lg12
                md12
                sm12
                xs12
                class="content-card"
            >
                <VLayout
                    wrap
                    align-center
                >
                    <VFlex
                        xs12
                        sm12
                        md11
                        lg11
                    >
                        <StepsProgressBar :step-number="stepNumber" />
                        <RouterView />
                    </VFlex>
                </VLayout>
            </VFlex>
        </div>
        <VFlex
            lg6
            md6
            hidden-sm-and-down
            height="100%"
            class="img-card"
        >
            <VImg :src="require('@/assets/running_man.jpg')" />
        </VFlex>
    </VContainer>
</template>

<script>
    import {mapGetters} from "vuex";
    import {IS_CURRENT_WEBSITE} from "@/store/modules/website/types/getters";
    import StepsProgressBar from '@/components/website/adding_master/StepsProgressBar.vue';

    export default {
        name: 'AddWebsitePage',
        components: {
            StepsProgressBar,
        },
        computed: {
            ...mapGetters('website', {
                isCurrentWebsite: IS_CURRENT_WEBSITE
            }),
            stepNumber () {
                return this.$route.meta.step;
            }
        },
        created() {
            if (this.isCurrentWebsite) {
                this.$router.replace({name: 'websiteinfo'});
            }
        }
    };
</script>

<style lang="scss" scoped>
    .content-card {
        background-color: rgb(245, 248, 253);

        ::v-deep .form-card {
            padding-top: 15px;

            .title-text {
                letter-spacing: 0.4px;
                line-height: 15px;
                color: rgba(18, 39, 55, 0.5);
            }
        }
    }
    .img-card {
        background-color: white;
    }
    .content-with-padding {
        width: 100%;
        padding-right: 0;
    }
    .left-container {
        display: flex;
    }
</style>
