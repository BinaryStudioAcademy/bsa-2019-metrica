<template>
    <VContent>
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
    import LoginForm from '@/components/auth/LoginForm.vue';
    import {isCurrentUser} from '../mixins/isCurrentUser';

    export default {
        mixins: [isCurrentUser],
        components: {
            LoginForm,
        },
        props: {
            redirectTo: {
                type: String,
                default: ''
            }
        },
        methods: {
            onSuccess() {
                if (this.redirectTo) {
                    this.$router.replace({path: this.redirectTo})
                        .catch(() => {});
                } else {
                    this.$router.replace({name: 'dashboard'})
                        .catch(() => {});
                }
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
