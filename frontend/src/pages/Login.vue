<template>
    <VContent>
        <VContainer
            fluid
            fill-height
            class="white pa-0"
        >
            <VLayout
                content
                wrap
                align-start
                justify-center
            >
                <VFlex
                    class="background pt-10"
                    fill-height
                    xs12
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
                    class="d-none d-md-flex pt-10"
                >
                    <VImg
                        src="/assets/images/home.png"
                        alt="Man"
                        contain
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
