<template>
    <VContent>
        <VContainer
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

    export default {
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
    padding-top: 40px;
}

.container{
    padding-top: 0px
}

.form-wrapper{
    padding-top: 40px;
    height: 100vh;
    background: #F2F2F2;
}




</style>
