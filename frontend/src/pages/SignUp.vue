<template>
    <VContent>
        <VContainer
            p-o
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
                        <SignUpForm />
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

.form-wrapper{
    height: 89vh;
    background: #f5f8fd;
}

</style>
