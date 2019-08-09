<template>
    <VContainer>
        <VLayout class="progress-panel">
            <VFlex
                ma-1
                xs4
                sm4
                md4
                class="progress-step"
                :class="{'active': stepNumber == 1,'filled': this.$parent.currentStepNumber >= 1}"
            >
                <div class="font-weight-bold step-name">Add name</div>
            </VFlex>
            <VFlex
                ma-1
                xs4
                sm4
                md4
                class="progress-step"
                :class="{'active': stepNumber == 2,'filled': this.$parent.currentStepNumber >= 2}"
            >
                <div class="font-weight-bold step-name">Add website</div>
            </VFlex>
            <VFlex
                ma-1
                xs4
                sm4
                md4
                class="progress-step"
                :class="{'active': stepNumber == 3,'filled': this.$parent.currentStepNumber > 2}"
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
        computed: {
            stepNumber () {
                return this.$parent.currentStepNumber;
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