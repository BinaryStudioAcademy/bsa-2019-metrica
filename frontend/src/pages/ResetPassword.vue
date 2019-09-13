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
                        <ResetPasswordForm />
                    </VLayout>
                </VFlex>
                <VFlex
                    image
                    sm12
                    md6
                    class="d-none d-md-flex mt-10"
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
    import ResetPasswordForm from "../components/auth/ResetPasswordForm";
    import {isCurrentUser} from '../mixins/isCurrentUser';

    export default {
        name: "ResetPassword",
        mixins: [isCurrentUser],
        components: {
            ResetPasswordForm
        }
    };
</script>

<style scoped>

</style>