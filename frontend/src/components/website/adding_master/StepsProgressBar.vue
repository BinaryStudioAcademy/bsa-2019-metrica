<template>
    <VContainer>
        <VLayout class="progress-panel">
            <VFlex
                ma-1
                xs4
                sm4
                md4
                class="progress-step"
                :class="{'active': currentStep === 1,'filled': currentStep >= 1}"
            >
                <div class="font-weight-bold step-name">Add name</div>
            </VFlex>
            <VFlex
                ma-1
                xs4
                sm4
                md4
                class="progress-step"
                :class="{'active': currentStep === 2,'filled': currentStep >= 2}"
            >
                <div class="font-weight-bold step-name">Add website</div>
            </VFlex>
            <VFlex
                ma-1
                xs4
                sm4
                md4
                class="progress-step"
                :class="{'active': currentStep === 3,'filled': currentStep > 2}"
            >
                <div class="font-weight-bold step-name"
                >
                    Tracking info
                </div>
            </VFlex>
        </VLayout>
    </VContainer>
</template>

<script>
    export default {
        name: 'StepsProgressBar',
        props: {
            stepNumber: Number
        },
        computed: {
            currentStep () {
                return this.stepNumber;
            }
        }
    };
</script>

<style lang="scss" scoped>
    .progress-panel {
        letter-spacing: 0.4px;

        .progress-step {
            height: 50px;
            line-height: 15px;
            color: rgba(18, 39, 55, 0.5);
            border-bottom: 3px solid rgba(0, 0, 0, 0.11);

            .step-name {
                font-size: 14px;
            }
        }
        .progress-step.filled {
            border-bottom: 3px solid #3C57DE;

        }
        .progress-step.active {
            line-height: 19px;

            .step-name {
                color: #122737;
                font-size: 17px;

            }
        }
    }
</style>