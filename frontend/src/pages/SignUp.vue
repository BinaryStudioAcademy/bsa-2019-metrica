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
                    class="d-sm-none d-md-flex"
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
    import SignUpForm from '@/components/auth/SignUpForm.vue';
    import {isCurrentUser} from '../mixins/isCurrentUser';

    export default {
        mixins: [isCurrentUser],
        components: {
            SignUpForm
        }
    };
</script>

<style lang="scss" scoped>

main{
    background: #FFFFFF;
}

.image{
    padding-top: 110px;
}

.container{
    padding: 0px
}

</style>
