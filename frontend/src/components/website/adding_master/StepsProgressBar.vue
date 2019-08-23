<template>
    <VContainer>
        <VLayout class="progress-panel">
            <VFlex
                ma-1
                xs4
                sm4
                md4
                class="progress-step"
                :class="firstStepClass"
            >
                <div
                    class="step-name"
                >
                    Add name
                </div>
            </VFlex>
            <VFlex
                ma-1
                xs4
                sm4
                md4
                class="progress-step"
                :class="secondStepClass"
            >
                <div
                    class="step-name"
                >
                    Add website
                </div>
            </VFlex>
            <VFlex
                ma-1
                xs4
                sm4
                md4
                class="progress-step"
                :class="thirdStepClass"
            >
                <div
                    class="step-name"
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
            stepNumber: {
                type: Number,
                required: true
            }
        },
        computed: {
            currentStep () {
                return this.stepNumber;
            },
            firstStepClass () {
                let classObj = {};
                if (this.currentStep === 1) {
                    classObj.active = true;
                }
                if (this.currentStep >= 1) {
                    classObj.filled = true;
                }
                return classObj;
            },
            secondStepClass () {
                let classObj = {};
                if (this.currentStep === 2) {
                    classObj.active = true;
                }
                if (this.currentStep >= 2) {
                    classObj.filled = true;
                }
                return classObj;
            },
            thirdStepClass () {
                let classObj = {};
                if (this.currentStep === 3) {
                    classObj.active = true;
                }
                if (this.currentStep >= 3) {
                    classObj.filled = true;
                }
                return classObj;
            },
        }
    };
</script>

<style lang="scss" scoped>
    .progress-panel {
        letter-spacing: 0.4px;

        .progress-step {
            height: 60px;
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