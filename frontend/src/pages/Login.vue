<template>
    <Spinner
        v-if="isLoading"
    />
    <VContent v-else>
        <VContainer
            fluid
            fill-height
        >
            <VLayout
                content
                wrap
                align-start
                justify-center
            >
                <VFlex
                    form-wrapper
                    xs12
                    sm8
                    md6
                >
                    <VLayout
                        column
                        align-items-center
                    >
                        <LoginForm
                            @success="onSuccess"
                        />
                    </VLayout>
                </VFlex>
                <VFlex
                    image
                    sm12
                    md6
                >
                    <VImg
                        src="/assets/images/home.png"
                        alt="Man"
                    />
                </VFlex>
            </VLayout>
        </VContainer>
    </VContent>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import {FETCH_CURRENT_WEBSITE} from "@/store/modules/website/types/actions";
    import {IS_CURRENT_WEBSITE} from "@/store/modules/website/types/getters";
    import Spinner from "@/components/utilites/Spinner";
    import LoginForm from '@/components/auth/LoginForm.vue';

    export default {
        components: {
            LoginForm,
            Spinner
        },
        data() {
            return {
                isLoading: false
            };
        },
        computed: {
            ...mapGetters('website', {
                isCurrentWebsite: IS_CURRENT_WEBSITE
            }),
        },
        methods: {
            ...mapActions('website', {
                fetchCurrentWebsite: FETCH_CURRENT_WEBSITE
            }),
            onSuccess() {
                this.isLoading = true;
                this.fetchCurrentWebsite().then(() => {
                    this.isLoading = false;
                    if (!this.isCurrentWebsite) {
                        this.$router.replace({name: 'add_website'});
                    } else {
                        this.$router.replace({name: 'dashboard'});
                    }
                });
            },
        },
    };
</script>

<style lang="scss" scoped>

    main{
        background: #FFFFFF;

    }

    .image{
        padding-top: 40px;
    }

    .container{
        padding: 0px

    }

    .form-wrapper{
        padding-top: 40px;
        height: 100%;
        background: #F2F2F2;
    }
</style>
