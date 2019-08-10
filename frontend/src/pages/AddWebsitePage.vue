<template>
    <VContainer
        fluid
        pa-0
    >
        <VLayout>
            <VFlex
                lg6
                md6
                sm12
                xs12
                class="content-card"
            >
                <VLayout
                    wrap
                    align-center
                    justify-center
                >
                    <VFlex
                        xs10
                        sm8
                        md10
                        lg8
                    >
                        <StepsProgressBar :stepNumber="stepNumber" />
                        <RouterView/>
                    </VFlex>
                </VLayout>
            </VFlex>
            <VFlex
                lg6
                md6
                hidden-sm-and-down
                height="100%"
                class="img-card"
            >
                <VImg :src="require('@/assets/running_man.jpg')"/>
            </VFlex>
        </VLayout>
    </VContainer>
</template>

<script>
    import StepsProgressBar from '@/components/website/adding_master/StepsProgressBar.vue';

    export default {
        name: 'AddWebsitePage',
        components: {
            StepsProgressBar,
        },
        computed: {
            stepNumber () {
                return this.$route.meta.step;
            }
        },
    };
</script>

<style lang="scss" scoped>
    .content-card {
        padding-top: 30px;
        background-color: rgb(245, 248, 253);
    }
    .img-card {
        background-color: white;
    }
</style>
