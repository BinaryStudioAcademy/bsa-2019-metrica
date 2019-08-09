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
                        xs12
                        sm10
                        md8
                        lg6
                    >
                        <StepsProgressBar />
                        <StepAddName v-if="currentStep.number === 1" @go-to-next-step="goToNextStep" />
                        <StepAddDomain v-if="currentStep.number === 2" @go-to-next-step="goToNextStep" />
                        <StepTrackingInfo v-if="currentStep.number === 3" :trackingInfoId="currentWebsite.tracking_info_id" />
                    </VFlex>
                </VLayout>
            </VFlex>
            <VFlex
                lg6
                md6
                hidden-sm-and-down
            >
                <VImg
                    :src="require('@/assets/running_man.jpg')"
                >
                </VImg>
            </VFlex>
        </VLayout>
    </VContainer>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
    import {ADD_NEW_WEBSITE} from "@/store/modules/website/types/actions";
    import {GET_CURRENT_WEBSITE} from "@/store/modules/website/types/getters";
    import StepsProgressBar from '../../components/website/adding_master/StepsProgressBar.vue';
    import StepAddName from '../../components/website/adding_master/StepAddName.vue';
    import StepAddDomain from '../../components/website/adding_master/StepAddDomain.vue';
    import StepTrackingInfo from '../../components/website/adding_master/StepTrackingInfo.vue';

    export default {
        name: 'AddWebsiteMaster',
        components: {
            StepsProgressBar,
            StepAddName,
            StepAddDomain,
            StepTrackingInfo
        },
        data: function () {
            return {
                newWebsite: {
                    name: null,
                    domain: null,
                    single_page: false,
                },
                currentStep: {
                    number: 1,
                    error: null
                },
            };
        },
        computed: {
            ...mapGetters('website', {
                currentWebsite: GET_CURRENT_WEBSITE
            }),
            currentError () {
                return this.currentStep.error;
            },
            currentStepNumber () {
                return this.currentStep.number;
            }
        },
        methods: {
            ...mapActions('website', {
                addNewWebsite: ADD_NEW_WEBSITE
            }),
            goToNextStep (data) {
                if (this.currentStep.number === 1) {
                    this.newWebsite.name = data.name;
                    this.currentStep.error = null;
                    this.currentStep.number++;
                } else if (this.currentStep.number === 2 ) {
                    this.currentStep.error = null;
                    this.newWebsite.domain = data.domain;
                    this.newWebsite.single_page = data.single_page;
                    this.onAddWebsite();
                }
            },
            goToErrorStep (step, error) {
                this.currentStep.number = step;
                this.currentStep.error = error;
            },
            onAddWebsite () {
                this.addNewWebsite(this.newWebsite).then((res) => {
                    this.refreshInput();
                    this.currentStep.number++;
                })
                    .catch((res) => {
                        this.onError(res.errors);
                    });
            },
            refreshInput () {
                this.newWebsite = {
                    name: null,
                    domain: null,
                    tracking_code_id: ''
                };
                this.currentStep.error = null;
            },
            onError (errors) {
                if(errors.name) {
                    this.goToErrorStep (1, errors.name)
                } else if (errors.domain) {
                    this.goToErrorStep (2, errors.domain)
                }
            },
        }
    };
</script>

<style lang="scss" scoped>
    .content-card {
        padding-top: 30px;
        background-color: rgb(245, 248, 253);
    }
</style>
