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
                        <SignUpForm />
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
    import SignUpForm from '@/components/auth/SignUpForm.vue';
    import {isCurrentUser} from '../mixins/isCurrentUser';

    export default {
        mixins: [isCurrentUser],
        components: {
            SignUpForm
        }
    };
</script>
